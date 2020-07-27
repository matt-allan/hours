<?php

declare(strict_types=1);

namespace App\Report;

use App\Report;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Output\OutputInterface;

class JsonRenderer implements Renderer
{
    public function render(OutputInterface $output, Report $report): void
    {
        $output->writeln(
            collect([
                'date_range' => [
                    'from' => $report->from()->presentDateTime(),
                    'to' => $report->to()->presentDateTime(),
                ],
                'frames' => $this->frames($report),
                'totals' => $report->aggregations()->filter(),
            ])
            ->toJSON(JSON_PRETTY_PRINT)
        );
    }

    private function frames(Report $report): Collection
    {
        return collect($report->data())
            ->map(function (Collection $row) use ($report) {
                return $report->headers()->combine($row);
            });
    }
}
