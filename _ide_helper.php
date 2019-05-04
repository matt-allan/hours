<?php

declare(strict_types=1);

namespace  {
    exit('This file should not be included, only analyzed by your IDE');
}

namespace Carbon {
    interface CarbonInterface
    {
        public function presentDate(): string;

        public function presentTime(): string;

        public function presentDateTime(): string;
    }
    class CarbonInterval
    {
        public function presentInterval(): string
        {
        }
    }
}

namespace Illuminate\Console {
    class Command {
        public function dateOption(string $key): ?\Carbon\CarbonInterface{}
    }
}

namespace Illuminate\Support {
    class Collection {
        public function toCsv(): string{}
    }
}
