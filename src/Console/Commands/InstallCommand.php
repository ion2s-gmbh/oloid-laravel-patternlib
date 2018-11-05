<?php

namespace Laratomics\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

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

        $this->registerViewResources();

        $this->info('Laratomics Workshop installed successfully.');

        return 0;
    }

    private function registerViewResources()
    {
        $viewConfig = file_get_contents(config_path('view.php'));
        $pathParts = explode('/', config('laratomics-workshop.basePath'));
        $basePath = array_pop($pathParts);
        $resourcePath = "resource_path('{$basePath}'),";
        if (!Str::contains($viewConfig, $resourcePath)) {
            file_put_contents(config_path('view.php'), str_replace(
                "resource_path('views'),".PHP_EOL,
                "resource_path('views'),".PHP_EOL."        ".$resourcePath.PHP_EOL,
                $viewConfig
            ));
            $this->comment('Extra view resources have been added in view.php');
        }
    }
}
