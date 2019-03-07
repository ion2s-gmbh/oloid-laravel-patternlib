<?php

namespace Oloid\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Oloid\Services\ConfigurationService;

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
    protected $description = 'Install all the Workshop Resources';

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
        $this->comment('Publishing Workshop Assets...');
        $this->callSilent('vendor:publish', ['--tag' => 'workshop-assets', '--force']);

        if ($this->configurationService->registerViewResources(config_path('view.php'))) {
            $this->comment('Extra view resources configuration have been added in the project\'s view.php');
        }

        if (!File::exists(config('workshop.patternPath'))) {
            $this->comment('Creating pattern path...');
            File::makeDirectory(config('workshop.patternPath'), 0755, true);
        }

        $this->info('Workshop installed successfully.');

        return 0;
    }
}
