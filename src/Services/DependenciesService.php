<?php


namespace Oloid\Services;


use Illuminate\Support\Facades\File;

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
        'head' => '',
        'body' => ''
    ];

    /**
     * GlobalsService constructor.
     */
    public function __construct()
    {
        $this->globalsPath = config('workshop.basePath') . '/' . config('workshop.resourcesFile');
        $this->loadGlobals();
    }

    /**
     * Get the defined globals.
     *
     * @param string $name
     * @return string
     */
    public function getGlobals(string $name): string
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
     * @param string $headerDependencies
     * @param string $bodyDependencies
     */
    public function storeDependencies(string $headerDependencies, string $bodyDependencies)
    {
        $this->globals['head'] = $headerDependencies;
        $this->globals['body'] = $bodyDependencies;

        File::put($this->globalsPath, json_encode($this->globals));
    }
}