<?php

declare(strict_types=1);

namespace App\Commands;

use App\Facades\Settings;
use App\Frame;
use App\Project;
use Illuminate\Support\Facades\Date;
use LaravelZero\Framework\Commands\Command;
use NunoMaduro\LaravelConsoleMenu\Menu;

class FrameEditCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'frame:edit';

    /**
     * @var string
     */
    protected $description = 'Edit or delete selected frame';

    public function handle()
    {
        $projectID = $this->askForProject();
        if ($projectID === null) {
            return 1;
        }
        $frameID = $this->askForFrame($projectID);
        if ($frameID === null) {
            return 1;
        }
        $frameAction = $this->askForAction($projectID, $frameID);
        if ($frameAction === null) {
            return 1;
        }

        if ($frameAction == 'delete') {
            if (! Frame::destroy($frameID)) {
                $this->getOutput()->writeln('<comment>Frame does not exist.</comment>');

                return 1;
            }

            $this->getOutput()->writeln('<info>Frame deleted.</info>');
        } else {
            $frameData = Frame::query()->where('id', $frameID)->with(['tags'])->first();

            $frame = new Frame();
            $frame->exists = true;
            $frame->id = $frameID;

            switch ($this->editFrameAction($projectID, $frameID)) {
                case 'start_time':
                    $startTime = $this->ask('Edit start time', $frameData->started_at->presentDateTime());

                    $frame->started_at = Date::parse($startTime, Settings::get('timezone'))->utc();
                    break;
                case 'stop_time':
                    $stopTime = $this->ask('Edit stop time', $frameData->stopped_at->presentDateTime());

                    $frame->stopped_at = Date::parse($stopTime, Settings::get('timezone'))->utc();
                    break;
                case 'tags':
                    $tags = $this->ask('Edit tags', $frameData->tags->implode('name', ', '));

                    $frame->tags()->detach();
                    $frame->addTags($tags);
                    break;
                case 'notes':
                    $notes = $this->ask('Edit notes', $frameData->notes);

                    $frame->addNotes($notes);
                    break;
            }

            if (! $frame->save()) {
                $this->getOutput()->writeln('<comment>Unknown error occurred. Changes weren\'t saved.</comment>');
            } else {
                $this->getOutput()->writeln('<info>Changes saved.</info>');
            }
        }
    }

    protected function askForProject()
    {
        $menu = (new Menu)
            ->setTitle('Project')
            ->setBackgroundColour('black')
            ->setForegroundColour('yellow')
            ->setExitButtonText('Cancel');

        Project::all()->map(function (Project $project) use ($menu) {
            return $menu->addOption($project->getKey(), $project->name);
        });

        return $menu->open();
    }

    protected function askForFrame($projectID)
    {
        $projectName = Project::query()->where('id', '=', $projectID)->first()->name;
        $menu = (new Menu)
            ->setTitle("$projectName > Frames")
            ->setBackgroundColour('black')
            ->setForegroundColour('yellow')
            ->setExitButtonText('Cancel');

        Frame::query()->latest()->with(['tags'])->where('project_id', $projectID)->get()->map(function (
            Frame $frame
        ) use ($menu) {
            if ($frame->stopped_at != null) {
                $menu->addOption($frame->getKey(),
                    "{$frame->started_at->presentDateTime()} - {$frame->stopped_at->presentTime()} - {$frame->notes} [{$frame->tags->implode('name', ',')}]");
            } else {
                $menu->addOption($frame->getKey(),
                    "{$frame->started_at->presentDateTime()} - {$frame->notes} [{$frame->tags->implode('name', ', ')}]");
            }
        });

        return $menu->open();
    }

    protected function askForAction($projectID, $frameID)
    {
        $projectName = Project::query()->where('id', '=', $projectID)->first()->name;
        $menu = (new Menu)
            ->setTitle("$projectName > Frames > $frameID")
            ->setBackgroundColour('black')
            ->setForegroundColour('yellow')
            ->setExitButtonText('Cancel')
            ->addOptions([
                'edit' => 'Edit frame',
                'delete' => 'Delete frame',
            ]);

        return $menu->open();
    }

    protected function editFrameAction($projectID, $frameID)
    {
        $projectName = Project::query()->where('id', '=', $projectID)->first()->name;
        $menu = (new Menu)
            ->setTitle("$projectName > Frames > $frameID > Edit")
            ->setBackgroundColour('black')
            ->setForegroundColour('yellow')
            ->setExitButtonText('Cancel')
            ->addOptions([
                'start_time' => 'Start Time',
                'stop_time' => 'Stop Time',
                'tags' => 'Tags',
                'notes' => 'Notes',
            ]);

        return $menu->open();
    }
}
