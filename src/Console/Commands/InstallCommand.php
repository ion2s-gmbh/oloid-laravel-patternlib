<?php

namespace Laratomics\Console\Commands;

use Illuminate\Console\Command;
use Laratomics\Services\ConfigurationService;

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
     * @var ConfigurationService
     */
    private $configurationService;

    /**
     * InstallCommand constructor.
     * @param ConfigurationService $configurationService
     */
    public function __construct(ConfigurationService $configurationService)
    {
        parent::__construct();
        $this->configurationService = $configurationService;
    }

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

        if ($this->configurationService->registerViewResources(config_path('view.php'))) {
            $this->comment('Extra view resources configuration have been added in the project\'s view.php');
        }

        $this->info('Laratomics Workshop installed successfully.');

        return 0;
    }
}
