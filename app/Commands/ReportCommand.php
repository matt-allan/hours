<?php

namespace App\Commands;

use App\Commands\Concerns\AcceptsDateRangeOptions;
use App\Report;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Date;
use LaravelZero\Framework\Commands\Command;

class ReportCommand extends Command
{
    use AcceptsDateRangeOptions {
        getFromOption as getParentFromOption;
    }

    /**
     * @var string
     */
    protected $signature = 'report
    {--project=* : The projects to include in the report}
    {--f|from= : The start time of the report}
    {--t|to= : the end time of the report}
    {--i|interval= : An interval for the length of the report}';

    /**
     * @var string
     */
    protected $description = 'Report the time spent on the given projects.';

    public function handle(): void
    {
        $from = $this->getFromOption() ?? $this->defaultFromOption();
        $to = $this->getToOption() ?? Date::now();

        $report = Report::create($from, $to, $this->option('project'));

        $this->info("{$from->presentDate()} to {$to->presentDate()}");
        $this->table($report->headers(), $report->data());
        $this->info("Total hours: {$report->total()->presentInterval()}");
    }

    private function defaultFromOption(): CarbonInterface
    {
        return Date::now($this->config()->timezone)->firstOfMonth()->utc();
    }
}
