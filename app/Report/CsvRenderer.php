<?php

declare(strict_types=1);

namespace App\Report;

use App\Report;
use Symfony\Component\Console\Output\OutputInterface;

class CsvRenderer implements Renderer
{
    public function render(OutputInterface $output, Report $report)
    {
        $output->write(
            $report
                ->data()
                ->prepend($report->headers())
                ->toCsv()
        );
    }
}
