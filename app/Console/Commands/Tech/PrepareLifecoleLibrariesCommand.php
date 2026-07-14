<?php

namespace App\Console\Commands\Tech;

use Illuminate\Console\Command;

class PrepareLifecoleLibrariesCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'lifecole:prepare-libraries';

    public function handle(): int
    {
        $env = $_SERVER['APP_ENV'] ?? $_ENV['APP_ENV'] ?? 'test';

        if ($env == 'local') {
            exec('cd packages/lifecole/event && git checkout main && cd ../../..');
            //exec('cd packages/lifecole/communications && git checkout main && cd ../../..');
            //exec('touch var/' . $env . '_' . time() . '.txt');
        }

        return 0;
    }
}
