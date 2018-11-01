<?php

namespace App\Providers;

use App\Services\PatternStateService;
use Exception;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class AtomicDesignServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('atom', function ($expression) {
            list($component, $extExpression) = $this->parse($expression, 'atoms');
            $this->checkRemoteState('atoms', $component);
            return "<?php echo view({$extExpression}, array_except(get_defined_vars(), array('__data', '__path')))->render() ?>";
        });

        Blade::directive('molecule', function ($expression) {
            list($component, $extExpression) = $this->parse($expression, 'molecules');
            $this->checkRemoteState('molecules', $component);
            return "<?php echo view({$extExpression}, array_except(get_defined_vars(), array('__data', '__path')))->render() ?>";
        });

        Blade::directive('organism', function ($expression) {
            list($component) = $this->parse($expression, 'organisms');
            $this->checkRemoteState('organisms', $component);
            return "<?php echo view('patterns.organisms.{$component}', array_except(get_defined_vars(), array('__data', '__path')))->render() ?>";
        });

        Blade::directive('template', function ($expression) {
            list($component, $extExpression) = $this->parse($expression, 'templates');
            $this->checkRemoteState('templates', $component);
            return "<?php echo view({$extExpression}, array_except(get_defined_vars(), array('__data', '__path')))->render() ?>";
        });

        Blade::directive('page', function ($expression) {
            list($component, $extExpression) = $this->parse($expression, 'pages');
            $this->checkRemoteState('pages', $component);
            return "<?php echo view({$extExpression}, array_except(get_defined_vars(), array('__data', '__path')))->render() ?>";
        });

        Blade::directive('element', function ($expression) {
            list($component, $extExpression) = $this->parse($expression);
            $this->checkRemoteState('atoms', $component);
            return "<?php echo view({$extExpression}, array_except(get_defined_vars(), array('__data', '__path')))->render() ?>";
        });
    }

    /**
     * Parse an atom expression.
     *
     * @param $expression
     * @return array
     */
    private function parseAtom($expression)
    {
        $parsed = [];
        preg_match('/(.*)%(.*)%/', $expression, $parsed);
        return $this->withoutFirst($parsed);
    }

    /**
     * Parse an expression.
     *
     * @param $expression
     * @param $path
     * @return array
     */
    private function parse($expression, $path = '')
    {
        $component = array_first(explode(',', $expression));
        $strippedComponent = str_replace("'", "", $component);
        $extComponent = "patterns.{$path}.{$strippedComponent}";
        $extExpression = str_replace($strippedComponent, "{$extComponent}", $expression);
        return [$strippedComponent, $extExpression];
    }

    /**
     * Parse an organism expression.
     *
     * @param $expression
     * @return array
     */
    private function parseOrganisms($expression)
    {
        $parsed = [];
        preg_match('/(.*)/', $expression, $parsed);
        return $this->withoutFirst($parsed);
    }

    /**
     * Parse a template expression.
     *
     * @param $expression
     * @return array
     */
    private function parseTemplate($expression)
    {
        $parsed = [];
        preg_match('/(.*)/', $expression, $parsed);
        return $this->withoutFirst($parsed);
    }

    /**
     * Parse a page expression.
     *
     * @param $expression
     * @return array
     */
    private function parsePage($expression)
    {
        $parsed = [];
        preg_match('/(.*)/', $expression, $parsed);
        return $this->withoutFirst($parsed);
    }

    /**
     * Parse a link expression.
     *
     * @param $expression
     * @return array
     */
    private function parseLink($expression)
    {
        $parsed = [];
        preg_match('/{(.*)\|(.*)}/', $expression, $parsed);
        return $this->withoutFirst($parsed);
    }

    private function parseElement($expression)
    {
        $parsed = [];
        preg_match('/(.*):(.*){(.*)}/', $expression, $parsed);
        return $this->withoutFirst($parsed);
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
     * @param $parsed
     * @return array
     */
    private function withoutFirst($parsed): array
    {
        unset($parsed[0]);
        return array_values($parsed);
    }

    /**
     * @param $section
     * @param $component
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws Exception
     */
    private function checkLocaleState($section, $component)
    {
        if (!config('app.debug')) {
            return;
        }
        $path = str_replace('.', '/', $component);
        $markdownFile = $path = base_path("resources/laratomics/patterns/{$section}/{$path}.md");
        $markdown = File::get($markdownFile);
        $metadata = YamlFrontMatter::parse($markdown);
        if ($metadata->state != 'DONE') {
            throw new Exception("Pattern {$section}.{$component} is not yet DONE!");
        }
    }

    /**
     * @param $section
     * @param $component
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws Exception
     */
    private function checkRemoteState($section, $component)
    {
        $patternStateService = $this->app->make(PatternStateService::class);
        $patternStateService->checkRemoteState($section, $component);
    }
}