<?php


namespace Oloid\Services;


use Illuminate\Support\Facades\File;

class ResourcesService
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
     * Get all global resources.
     * @return array
     */
    public function getAll()
    {
        return $this->globals;
    }

    /**
     * Add a new global resources.
     *
     * @param string $headResources
     * @param string $bodyResources
     */
    public function store(string $headResources, string $bodyResources)
    {
        $this->globals['head'] = $headResources;
        $this->globals['body'] = $bodyResources;

        File::put($this->globalsPath, json_encode($this->globals));
    }
}