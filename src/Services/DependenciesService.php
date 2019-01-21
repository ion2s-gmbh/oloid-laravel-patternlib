<?php


namespace Laratomics\Services;


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
}