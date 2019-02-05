<?php

namespace Unit\Services;

use Illuminate\Support\Str;
use Oloid\Services\ConfigurationService;
use Tests\BaseTestCase;
use Tests\Traits\TestStubs;

class ConfigurationServiceTest extends BaseTestCase
{
    use TestStubs;

    /**
     * @var ConfigurationService
     */
    private $cut;

    /**
     * @var string
     */
    private $viewConfigPath;

    /**
     * Setup before testing.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->cut = new ConfigurationService();
        $this->prepareViewConfigStub();
    }

    /**
     * @test
     * @covers \Oloid\Services\ConfigurationService
     */
    public function it_should_add_extra_path_to_view_config()
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
     * @covers \Oloid\Services\ConfigurationService
     */
    public function it_should_add_extra_path_to_view_config_only_once()
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
