<?php

namespace App\Console\Commands\Tech;

use Illuminate\Console\Command;

class PrepareMi-empresaLibrariesCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'mi-empresa:prepare-libraries';

    public function handle(): int
    {
        $env = $_SERVER['APP_ENV'] ?? $_ENV['APP_ENV'] ?? 'test';

        if ($env == 'local') {
            exec('cd packages/mi-empresa/event && git checkout main && cd ../../..');
            //exec('cd packages/mi-empresa/communications && git checkout main && cd ../../..');
            //exec('touch var/' . $env . '_' . time() . '.txt');
        }

        return 0;
    }
}
