<?php

namespace Laratomics\Providers;

use Closure;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Laratomics\Services\PatternService;
use Laratomics\Services\PatternStatusService;

class PatternServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(PatternStatusService::class, function ($app) {
            return new PatternStatusService();
        });

        $components = $this->getComponents();
        foreach ($components as $component => $path) {
            Blade::directive($component, $this->directiveResolution($path));
        }
    }

    /**
     * Get available components for registering custom directives.
     *
     * @return array
     */
    private function getComponents(): array
    {
        $fs = new Filesystem();

        if (!$fs->exists(pattern_path())) {
            return [];
        }

        $directories = $fs->directories(pattern_path());
        $components = [];
        foreach ($directories as $directory) {
            if (dir_contains_any($directory, 'blade.php')) {
                $componentParts = explode('/', $directory);
                $component = array_pop($componentParts);
                $components[$component] = $component;
            }
        }

        return $components;
    }

    /**
     * Parse an expression.
     *
     * @param $expression
     * @param $path
     * @return string
     */
    private function parse($expression, $path = ''): string
    {
        $component = array_first(explode(',', $expression));
        $strippedComponent = str_replace("'", "", $component);
        $parts = explode('/', pattern_path());
        $prefix = array_pop($parts);

        $extComponent = "{$prefix}.{$path}.{$strippedComponent}";
        $extExpression = str_replace($strippedComponent, "{$extComponent}", $expression);

        $this->evaluatePatternStatus("{$path}.{$strippedComponent}");

        return $extExpression;
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Generate the Closure for the directive.
     *
     * @param $path
     * @return Closure
     */
    public function directiveResolution($path): Closure
    {
        return function ($expression) use ($path) {
            $extExpression = $this->parse($expression, $path);
            return "<?php echo view({$extExpression}, array_except(get_defined_vars(), array('__data', '__path')))->render() ?>";
        };
    }

    /**
     * Evaluate the Patter's status that is defined in the Pattern's markdown file.
     *
     * @param string $pattern
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function evaluatePatternStatus(string $pattern)
    {
        $patternService = $this->app->make(PatternService::class);
        $patternStatusService = $this->app->make(PatternStatusService::class);
        $pattern = $patternService->loadPattern($pattern);
        $patternStatusService->evaluate($pattern);
    }
}