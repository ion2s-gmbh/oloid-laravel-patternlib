<?php


namespace Oloid\Services;


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
     * Add a new global dependency.
     *
     * @param string $dependency
     */
    public function addDependency(string $dependency)
    {
        list($type, $src, $integrity, $crossorigin) = $this->extract($dependency);
        $hash = hash('md5', $src);

        if (! $this->dependencyExists($type, $hash)) {
            $this->globals[$type][$hash] = [
                'src' => $src,
                'integrity' => $integrity,
                'crossorigin' => $crossorigin
            ];
        }

        File::put($this->globalsPath, json_encode($this->globals));
    }

    /**
     * Extract parts of the given dependency.
     *
     * @param string $dependency
     * @return array
     */
    private function extract(string $dependency): array
    {
        if (starts_with($dependency, '<script')) {
            return $this->extractScript($dependency);
        }

        return $this->extractStyle($dependency);
    }

    /**
     * Extract parts of the given script dependency.
     * @param string $dependency
     * @return array
     */
    private function extractScript(string $dependency): array
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
    private function extractStyle(string $dependency): array
    {
        $dom = new Dom();
        $dom->load($dependency);
        $linkElement = $dom->getElementsByTag('link')[0];
        $src = $linkElement->getAttribute('href');
        $integrity = $linkElement->getAttribute('integrity');
        $crossorigin = $linkElement->getAttribute('crossorigin');
        return ['styles', $src, $integrity, $crossorigin];
    }

    /**
     * Check if a global dependency exists.
     *
     * @param string $type
     * @param string $hash
     * @return bool
     */
    public function dependencyExists(string $type, string $hash)
    {
        return array_key_exists($hash, $this->globals[$type]);
    }

    /**
     * Remove a global dependency.
     *
     * @param string $type
     * @param string $hash
     */
    public function removeDependency(string $type, string $hash)
    {
        unset($this->globals[$type][$hash]);
        File::put($this->globalsPath, json_encode($this->globals));
    }
}