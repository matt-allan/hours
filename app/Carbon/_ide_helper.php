<?php
namespace  {
    exit("This file should not be included, only analyzed by your IDE");
}
namespace Carbon {
    interface CarbonInterface {
        public function presentDate(): string;
        public function presentTime(): string;
        public function presentDateTime(): string;
    }
    class CarbonInterval {
        public function presentInterval(): string{}
    }
}
