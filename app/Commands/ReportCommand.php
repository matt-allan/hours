<?php

declare(strict_types=1);

namespace App\Commands;

use App\Report;
use Carbon\CarbonInterval;
use Carbon\CarbonInterface;
use LaravelZero\Framework\Commands\Command;

class ReportCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'report
    {--project=* : The projects to include in the report}
    {--f|from= : The start time of the report}
    {--t|to= : the end time of the report}
    {--i|interval= : An interval for the length of the report}
    {--format=text : The output format for the report.  Available options: text, csv, json}
    {--tag=* : The tags to include on the report}';

    /**
     * @var string
     */
    protected $description = 'Report the time spent on the given projects.';

    public function handle(): void
    {
        Report::build()
            ->from($this->dateOption('from'))
            ->to($this->option('interval') ? $this->getInterval() : $this->dateOption('to'))
            ->projects($this->option('project'))
            ->tags($this->option('tag'))
            ->create()
            ->render($this->output, $this->option('format'));
    }

    private function getInterval(): CarbonInterface
    {
        return $this->dateOption('from')
            ->add(CarbonInterval::fromString($this->option('interval')))
            ->utc();
    }
}
