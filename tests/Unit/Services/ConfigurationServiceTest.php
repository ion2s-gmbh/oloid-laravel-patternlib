<?php

namespace Tests\Unit\Services;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Laratomics\Services\ConfigurationService;
use Laratomics\Tests\BaseTestCase;

class ConfigurationServiceTest extends BaseTestCase
{
    /**
     * @var ConfigurationService
     */
    private $cut;

    /**
     * @var string
     */
    private $viewConfigPath;

    protected function setUp()
    {
        parent::setUp();
        $this->cut = new ConfigurationService();

        // prepare view config double
        $fs = new Filesystem();
        $sourcePath = realpath(__DIR__ . '/../../stubs/view.php');
        $this->viewConfigPath = "{$this->tempDir}/view.php";
        $fs->copy($sourcePath, $this->viewConfigPath);
    }

    /**
     * @test
     * @covers \Laratomics\Services\ConfigurationService
     */
    public function it_should_add_extra_laratomics_path_to_view_config()
    {
        // arrange
        $resourcePath = $this->getResourcePathString();
        $viewConfig = file_get_contents($this->viewConfigPath);
        $this->assertFalse(Str::contains($viewConfig, $resourcePath));

        // act
        $this->assertTrue($this->cut->registerViewResources($this->viewConfigPath));

        // assert
        $viewConfig = file_get_contents($this->viewConfigPath);
        $this->assertTrue(Str::contains($viewConfig, $resourcePath));
    }

    /**
     * @test
     * @covers \Laratomics\Services\ConfigurationService
     */
    public function it_should_add_extra_laratomics_path_to_view_config_only_once()
    {
        // arrange
        $resourcePath = $this->getResourcePathString();
        $viewConfig = file_get_contents($this->viewConfigPath);
        $this->assertFalse(Str::contains($viewConfig, $resourcePath));

        // act
        $this->assertTrue($this->cut->registerViewResources($this->viewConfigPath));

        // assert
        $viewConfig = file_get_contents($this->viewConfigPath);
        $this->assertTrue(Str::contains($viewConfig, $resourcePath));

        // add resource_path twice
        $this->assertFalse($this->cut->registerViewResources($this->viewConfigPath));
        $viewConfig = file_get_contents($this->viewConfigPath);
        $this->assertTrue(Str::contains($viewConfig, $resourcePath));
    }

    /**
     * Get the resource_path string for view configuration.
     *
     * @return string
     */
    protected function getResourcePathString(): string
    {
        $pathParts = explode('/', config('workshop.basePath'));
        $basePath = array_pop($pathParts);
        $resourcePath = "resource_path('{$basePath}'),";
        return $resourcePath;
    }
}
