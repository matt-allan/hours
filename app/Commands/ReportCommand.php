<?php

declare(strict_types=1);

namespace App\Commands;

use App\Report;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Date;
use LaravelZero\Framework\Commands\Command;
use App\Commands\Concerns\AcceptsDateRangeOptions;

class ReportCommand extends Command
{
    use AcceptsDateRangeOptions;

    /**
     * @var string
     */
    protected $signature = 'report
    {--project=* : The projects to include in the report}
    {--f|from= : The start time of the report}
    {--t|to= : the end time of the report}
    {--i|interval= : An interval for the length of the report}
    {--format=text : The output format for the report.  Available options: text, csv, json}';

    /**
     * @var string
     */
    protected $description = 'Report the time spent on the given projects.';

    public function handle(): void
    {
        $from = $this->getFromOption() ?? $this->defaultFromOption();
        $to = $this->getToOption() ?? Date::now();

        Report::create($from, $to, $this->option('project'))
            ->render($this->output, $this->option('format'));
    }

    private function defaultFromOption(): CarbonInterface
    {
        return Date::now($this->config()->timezone)->firstOfMonth()->utc();
    }
}
