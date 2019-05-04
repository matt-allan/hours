<?php

declare(strict_types=1);

namespace App\Events;

use App\Facades\Config;
use Carbon\CarbonTimeZone;
use Illuminate\Console\Events\CommandStarting;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Prompts the user to configure a timezone if it isn't set.
 */
class ConfigureTimezone
{
    public function handle(CommandStarting $event): void
    {
        if (Config::get('timezone') || ! in_array($event->command, ['start', 'add', 'report'])) {
            return;
        }

        $output = new SymfonyStyle($event->input, $event->output);

        $timezone = $output->askQuestion(
            (new Question('What is your current timezone?', $this->guessTimezone()))
                ->setAutocompleterValues(CarbonTimeZone::listIdentifiers())
        );

        Config::set('timezone', $timezone);
    }

    private function guessTimezone(): ?string
    {
        if (PHP_OS_FAMILY === 'win') {
            // TODO: something like `systeminfo | findstr ”Time Zone”`?  Maybe we can use tzutil?
            return null;
        }

        $offset = (int) exec('date +%z');
        $abbr = exec('date +%Z');

        if (! $offset || ! $abbr) {
            return null;
        }

        if ($timezone = timezone_name_from_abbr($abbr, (int) $offset)) {
            return $timezone;
        }

        return null;
    }
}
