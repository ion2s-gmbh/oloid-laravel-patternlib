<?php

namespace Laratomics\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workshop:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all the Laratomics Workshop Resoureces';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment('Publishing Laratomics Workshop Assets...');
        $this->callSilent('vendor:publish', ['--tag' => 'workshop-assets']);

        $this->comment('Publishing Laratomics Workshop Configuration...');
        $this->callSilent('vendor:publish', ['--tag' => 'workshop-config']);

        $this->info('Laratomics Workshop installed successfully.');

        return 0;
    }
}
