<?php

namespace Laratomics\Providers;

use Exception;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class PatternServiceProvider extends ServiceProvider
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
            return "<?php echo view({$extExpression}, array_except(get_defined_vars(), array('__data', '__path')))->render() ?>";
        });

        Blade::directive('molecule', function ($expression) {
            list($component, $extExpression) = $this->parse($expression, 'molecules');
            return "<?php echo view({$extExpression}, array_except(get_defined_vars(), array('__data', '__path')))->render() ?>";
        });

        Blade::directive('organism', function ($expression) {
            list($component) = $this->parse($expression, 'organisms');
            return "<?php echo view('patterns.organisms.{$component}', array_except(get_defined_vars(), array('__data', '__path')))->render() ?>";
        });

        Blade::directive('template', function ($expression) {
            list($component, $extExpression) = $this->parse($expression, 'templates');
            return "<?php echo view({$extExpression}, array_except(get_defined_vars(), array('__data', '__path')))->render() ?>";
        });

        Blade::directive('page', function ($expression) {
            list($component, $extExpression) = $this->parse($expression, 'pages');
            return "<?php echo view({$extExpression}, array_except(get_defined_vars(), array('__data', '__path')))->render() ?>";
        });

        Blade::directive('element', function ($expression) {
            list($component, $extExpression) = $this->parse($expression);
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
        $parts = explode('/', config('workshop.patternPath'));
        $prefix = array_pop($parts);

        $extComponent = "{$prefix}.{$path}.{$strippedComponent}";
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
}