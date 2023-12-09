<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TidyLibraryCommand extends Command
{
    protected $signature = 'charon:tidy';
    protected $hidden = true;

    public function handle(): int
    {
        $this->warn('charon:tidy has been renamed. Use charon:prune instead.');

        return self::SUCCESS;
    }
}
