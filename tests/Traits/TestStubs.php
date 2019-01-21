<?php


namespace Tests\Traits;

use Illuminate\Filesystem\Filesystem;
use Laratomics\Models\Pattern;
use Laratomics\Services\PatternService;

trait TestStubs
{
    /**
     * Prepare a whole Pattern file structure for the test.
     * @param $name
     * @param $description
     * @return Pattern
     */
    private function preparePattern($name, $description): Pattern
    {
        $patternService = app()->make(PatternService::class);
        return $patternService->createPattern($name, $description);
    }

    /**
     * Copy a view.php config file in place for testing.
     */
    public function prepareViewConfigStub()
    {
        $fs = new Filesystem();
        $sourcePath = realpath(__DIR__ . '/../Stubs/view.php');
        $this->viewConfigPath = "{$this->tempDir}/view.php";
        $fs->copy($sourcePath, $this->viewConfigPath);
    }

    public function preparePatternStub()
    {
        $fs = new Filesystem();
        $sourcePath = realpath(__DIR__ . '/../Stubs/patterns');
        $targetPath = "{$this->tempDir}/patterns";
        $fs->copyDirectory($sourcePath, $targetPath);
    }

    public function prepareGlobalsStub()
    {
        $fs = new Filesystem();
        $sourcePath = realpath(__DIR__ . '/../Stubs/dependencies.json');
        $targetPath = "{$this->tempDir}/dependencies.json";
        $fs->copy($sourcePath, $targetPath);
    }
}