<?php

declare(strict_types=1);

namespace App\Report;

use App\Report;
use Symfony\Component\Console\Output\OutputInterface;

interface Renderer
{
    public function render(OutputInterface $output, Report $report);
}
