<?php


namespace Laratomics\Services;


use Illuminate\Support\Facades\File;
use PHPHtmlParser\Dom;

class DependenciesService
{
    /**
     * Path to the globals file.
     * @var string
     */
    private $globalsPath = '';

    /**
     * Loaded globals definitions.
     * @var array
     */
    private $globals = [
        'fonts' => [],
        'styles' => [],
        'scripts' => []
    ];

    /**
     * GlobalsService constructor.
     */
    public function __construct()
    {
        $this->globalsPath = config('workshop.basePath') . '/' . config('workshop.dependenciesFile');
        $this->loadGlobals();
    }

    /**
     * Get the defined globals.
     *
     * @return array
     */
    public function getGlobals(string $name): array
    {
        return $this->globals[$name];
    }

    /**
     * Load the globals.
     */
    public function loadGlobals()
    {
        if (File::exists($this->globalsPath)) {
            $json = File::get($this->globalsPath);
            $this->globals = json_decode($json, true);
        }
    }

    /**
     * Get all global dependencies.
     * @return array
     */
    public function getAllGlobals()
    {
        return $this->globals;
    }

    /**
     * Add a new
     *
     * @param string $dependency
     */
    public function addDependency(string $dependency)
    {
        list($type, $src, $integrity, $crossorigin) = $this->evaluate($dependency);
        $this->globals[$type][] = [
            'src' => $src,
            'integrity' => $integrity,
            'crossorigin' => $crossorigin
        ];

        File::put($this->globalsPath, json_encode($this->globals));
    }

    private function evaluate(string $dependency): array
    {
        if (starts_with($dependency, '<script')) {
            return $this->evaluateScript($dependency);
        }

        return $this->evaluateStyle($dependency);
    }

    private function evaluateScript(string $dependency): array
    {
        $dom = new Dom();
        $dom->load($dependency, ['removeScripts' => false]);
        $scriptElement = $dom->getElementsByTag('script')[0];
        $src = $scriptElement->getAttribute('src');
        $integrity = $scriptElement->getAttribute('integrity');
        $crossorigin = $scriptElement->getAttribute('crossorigin');
        return ['scripts', $src, $integrity, $crossorigin];
    }

    /**
     * Extract 'href', 'integrity' and 'crossorigin' attributes of a link style definition.
     *
     * @param string $dependency
     * @return array
     */
    private function evaluateStyle(string $dependency): array
    {
        $dom = new Dom();
        $dom->load($dependency);
        $linkElement = $dom->getElementsByTag('link')[0];
        $src = $linkElement->getAttribute('href');
        $integrity = $linkElement->getAttribute('integrity');
        $crossorigin = $linkElement->getAttribute('crossorigin');
        return ['styles', $src, $integrity, $crossorigin];
    }
}