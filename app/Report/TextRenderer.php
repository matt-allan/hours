<?php

declare(strict_types=1);

namespace App\Report;

use App\Report;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Output\OutputInterface;

class TextRenderer implements Renderer
{
    public function render(OutputInterface $output, Report $report): void
    {
        $output->writeln("<info>{$report->from()->presentDate()} to {$report->to()->presentDate()}</info>");

        (new Table($output))
            ->setHeaders($report->headers()->toArray())
            ->setRows($report->data()->toArray())
            ->addRow(new TableSeparator())
            ->addRow(
                $report
                    ->headers()
                    ->mapWithKeys(function ($header) {
                        return [$header => null];
                    })
                    ->merge($report->aggregations())
                    ->toArray()
            )
            ->render();

        $output->writeln("<info>Total hours: {$report->total()->presentInterval()}</info>");
    }
}
