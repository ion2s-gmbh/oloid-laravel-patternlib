<?php

namespace Laratomics\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class PatternServiceProvider extends ServiceProvider
{
    private $components = [
        'atom' => 'atoms',
        'molecule' => 'moleculess',
        'organism' => 'organisms',
        'template' => 'templates',
        'page' => 'pages',
        'element' => '',
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->components as $component => $path) {
            Blade::directive($component, function ($expression) use ($path) {
                $extExpression = $this->parse($expression, $path);
                return "<?php echo view({$extExpression}, array_except(get_defined_vars(), array('__data', '__path')))->render() ?>";
            });
        }
//        Blade::directive('atom', function ($expression) {
//            $extExpression = $this->parse($expression, 'atoms');
/*            return "<?php echo view({$extExpression}, array_except(get_defined_vars(), array('__data', '__path')))->render() ?>";*/
//        });
//
//        Blade::directive('molecule', function ($expression) {
//            $extExpression = $this->parse($expression, 'molecules');
/*            return "<?php echo view({$extExpression}, array_except(get_defined_vars(), array('__data', '__path')))->render() ?>";*/
//        });
//
//        Blade::directive('organism', function ($expression) {
//            $extExpression = $this->parse($expression, 'molecules');
/*            return "<?php echo view({$extExpression}, array_except(get_defined_vars(), array('__data', '__path')))->render() ?>";*/
//        });
//
//        Blade::directive('template', function ($expression) {
//            $extExpression = $this->parse($expression, 'templates');
/*            return "<?php echo view({$extExpression}, array_except(get_defined_vars(), array('__data', '__path')))->render() ?>";*/
//        });
//
//        Blade::directive('page', function ($expression) {
//            $extExpression = $this->parse($expression, 'pages');
/*            return "<?php echo view({$extExpression}, array_except(get_defined_vars(), array('__data', '__path')))->render() ?>";*/
//        });
//
//        Blade::directive('element', function ($expression) {
//            $extExpression = $this->parse($expression);
/*            return "<?php echo view({$extExpression}, array_except(get_defined_vars(), array('__data', '__path')))->render() ?>";*/
//        });
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
        return $extExpression;
    }

//    /**
//     * Parse a link expression.
//     *
//     * @param $expression
//     * @return array
//     */
//    private function parseLink($expression)
//    {
//        $parsed = [];
//        preg_match('/{(.*)\|(.*)}/', $expression, $parsed);
//        return $this->withoutFirst($parsed);
//    }
//
//    /**
//     * @param $parsed
//     * @return array
//     */
//    private function withoutFirst($parsed): array
//    {
//        unset($parsed[0]);
//        return array_values($parsed);
//    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}