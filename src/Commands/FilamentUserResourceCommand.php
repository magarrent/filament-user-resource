<?php

namespace Magarrent\FilamentUserResource\Commands;

use Illuminate\Console\Command;

class FilamentUserResourceCommand extends Command
{
    public $signature = 'filament-user-resource';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
