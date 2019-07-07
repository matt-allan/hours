<?php

declare(strict_types=1);

namespace App\Commands;

use App\Settings\Repository;
use LaravelZero\Framework\Commands\Command;
use Stecman\Component\Symfony\Console\BashCompletion\CompletionContext;
use Stecman\Component\Symfony\Console\BashCompletion\Completion\CompletionAwareInterface;

class SettingsEditCommand extends Command implements CompletionAwareInterface
{
    /**
     * @var string
     */
    protected $signature = 'settings:edit
    {key : The key to edit}
    {value : The value to set}';

    /**
     * @var string
     */
    protected $help = <<<'HELP'
The settings:edit command requires two arguments: the name of the setting to
edit and the value to set it to.

The following settings are supported:

timezone: The timezone to use for input and display. Must be one of the timezones
supported by PHP.  See https://www.php.net/manual/en/timezones.php for a complete
list.

date_format: The format string to use for dates.  Defaults to `F j, Y`. See the
PHP documentation for more info: https://www.php.net/manual/en/function.date.php

date_format: The format string to use for times.  Defaults to `g:i a`. See the
PHP documentation for more info: https://www.php.net/manual/en/function.date.php

interval_format: The format string to use for intervals.  Defaults to `%h:%I`.
See the PHP documentation for more info: https://www.php.net/manual/en/dateinterval.format.php

default_project: The project used when executing command without providing project argument.
When this value is missing or null a project must be provided with each command that uses project argument.
HELP;

    public function __construct()
    {
        parent::__construct();

        $this->setHelp($this->help);
    }

    /**
     * @var string
     */
    protected $description = 'Edit the application settings.';

    public function handle(Repository $settings): void
    {
        $settings->set($this->argument('key'), $this->argument('value'));

        $this->info("Updated {$this->argument('key')} to {$this->argument('value')}");
    }

    public function completeOptionValues($optionName, CompletionContext $context): array
    {
        return [];
    }

    public function completeArgumentValues($argumentName, CompletionContext $context): array
    {
        switch ($argumentName) {
            case 'key':
                return ['timezone', 'date_format', 'time_format', 'interval_format', 'default_project'];
            default:
                return [];
        }
    }
}
