<?php

declare(strict_types=1);

namespace App;

use Carbon\CarbonInterval;
use Carbon\CarbonInterface;
use App\Report\RendererFactory;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Output\OutputInterface;

class Report
{
    /**
     * @var Frame[]|Collection
     */
    private $frames;

    /**
     * @var CarbonInterface
     */
    private $from;

    /**
     * @var CarbonInterface
     */
    private $to;

    /**
     * @var string[]
     */
    private $projects;

    /**
     * @param Collection|Frame[] $frames
     * @param CarbonInterface    $from
     * @param CarbonInterface    $to
     * @param string[]           $projects
     */
    public function __construct(
        Collection $frames,
        CarbonInterface $from,
        CarbonInterface $to,
        array $projects = []
    ) {
        $this->frames = $frames;
        $this->from = $from;
        $this->to = $to;
        $this->projects = $projects;
    }

    public static function build(): ReportBuilder
    {
        return new ReportBuilder();
    }

    /**
     * @return CarbonInterface
     */
    public function from(): CarbonInterface
    {
        return $this->from;
    }

    /**
     * @return CarbonInterface
     */
    public function to(): CarbonInterface
    {
        return $this->to;
    }

    public function headers(): Collection
    {
        return collect(['Project', 'Date', 'Start', 'End', 'Elapsed'])
            ->unless($this->multipleProjects(), function (Collection $headers) {
                return $headers->slice(1);
            });
    }

    public function data(): Collection
    {
        return $this->frames->map(function (Frame $frame) {
            return collect([
               $frame->project->name,
               $frame->started_at->presentDate(),
               $frame->started_at->presentTime(),
               $frame->stopped_at->presentTime(),
               $frame->elapsed->presentInterval(),
           ]);
        })->unless($this->multipleProjects(), function (Collection $frames) {
            return $frames
               ->map(function (Collection $frame) {
                   return $frame->slice(1);
               });
        });
    }

    public function total(): CarbonInterval
    {
        return $this->frames
            ->pluck('elapsed')
            ->reduce(function (CarbonInterval $carry, CarbonInterval $item): CarbonInterval {
                return $item->add($carry);
            }, new CarbonInterval(null));
    }

    public function render(OutputInterface $output, string $format): void
    {
        app(RendererFactory::class)->make($format)->render($output, $this);
    }

    private function multipleProjects(): bool
    {
        return count($this->projects) !== 1;
    }
}
