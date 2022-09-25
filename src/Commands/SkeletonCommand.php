<?php

namespace Pirumart\Uganda\Locale\Commands;

use Illuminate\Console\Command;

class SkeletonCommand extends Command
{
    public $signature = 'pirumart:uganda-locale';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
