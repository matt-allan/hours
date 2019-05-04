<?php

declare(strict_types=1);

namespace App\Report;

use App\Report;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;

class TextRenderer implements Renderer
{
    public function render(OutputInterface $output, Report $report): void
    {
        $output->writeln("<info>{$report->start()->presentDate()} to {$report->end()->presentDate()}</info>");

        (new Table($output))
            ->setHeaders($report->headers()->toArray())
            ->setRows($report->data()->toArray())
            ->render();

        $output->writeln("<info>Total hours: {$report->total()->presentInterval()}</info>");
    }
}
