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

    /**
     * @var string
     */
    protected $help = <<<'HELP'
The start time of the report may be specified with the --from option. The start
time may be any textual datetime format such as '2019-05-01 22:34:46' or a human
readable difference such as '2 hours ago'. If the start time is not specified it
will default to the first of the current month.

You may specify an end time with the --to option. The --to option accepts all of
the same datetime formats as the --from option.

If you would rather specify an interval than a specific end time you can use the
--interval option. The --interval option accepts intervals such as '3h 12m'
(meaning 3 hours, 12 minutes in this example).

If neither the --to or --interval options are specified the end time will
default to the current time.

The report format may be specified with the --format option. Available options
are text, CSV, and JSON.

The report can be filtered by tag or project with the --tag and --project
options.  If not specified frames for all tags and projects are included.

The report is printed to STDOUT. You can pipe the output to create a file, i.e.
`hours report --format csv > timesheet.csv`.
HELP;

    public function __construct()
    {
        parent::__construct();

        $this->setHelp($this->help);
    }

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
