<?php

declare(strict_types=1);

namespace App\Report;

use App\Report;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
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
                'total' => $report->total()->presentInterval(),
                'frames' => $this->frames($report),
            ])
            ->toJSON(JSON_PRETTY_PRINT)
        );
    }

    private function frames(Report $report): Collection
    {
        $headers = $report->headers()->map(function (string $header) {
            return Str::lower($header);
        });

        return collect($report->data())
            ->map(function (Collection $row) use ($headers) {
                return $headers->combine($row);
            });
    }
}
