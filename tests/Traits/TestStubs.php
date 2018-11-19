<?php


namespace Laratomics\Tests\Traits;

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
        // prepare view config double
        $fs = new Filesystem();
        $sourcePath = realpath(__DIR__ . '/../stubs/view.php');
        $this->viewConfigPath = "{$this->tempDir}/view.php";
        $fs->copy($sourcePath, $this->viewConfigPath);
    }

}