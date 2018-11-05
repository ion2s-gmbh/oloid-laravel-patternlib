<?php


namespace Laratomics\Services;


use Illuminate\Support\Str;

class ConfigurationService
{
    /**
     * Add the workshop's base path to view.php
     * @return bool
     */
    public function registerViewResources(): bool
    {
        $viewConfig = file_get_contents(config_path('view.php'));
        $pathParts = explode('/', config('workshop.basePath'));
        $basePath = array_pop($pathParts);
        $resourcePath = "resource_path('{$basePath}'),";
        if (!Str::contains($viewConfig, $resourcePath)) {
            file_put_contents(config_path('view.php'), str_replace(
                "resource_path('views'),".PHP_EOL,
                "resource_path('views'),".PHP_EOL."        ".$resourcePath.PHP_EOL,
                $viewConfig
            ));
            return true;
        }
        return false;
    }
}