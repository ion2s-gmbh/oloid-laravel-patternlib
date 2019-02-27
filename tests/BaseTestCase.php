<?php


namespace Tests;

use Illuminate\Filesystem\Filesystem;
use Oloid\Providers\PatternServiceProvider;
use Oloid\WorkshopServiceProvider;
use Orchestra\Testbench\TestCase;

abstract class BaseTestCase extends TestCase
{
    /**
     * Temporary testing folder.
     * @var string
     */
    protected $tempDir = __DIR__ . '/tmp';

    /**
     * Setup before testing.
     */
    protected function setUp(): void
    {
        $this->deleteTempDirectory();
        mkdir($this->tempDir);
        parent::setUp();
    }

    /**
     * Cleanup after testing.
     */
    protected function tearDown(): void
    {
        $this->deleteTempDirectory();
        parent::tearDown();
    }

    /**
     * Delete the temp testing directory if it exists.
     */
    protected function deleteTempDirectory(): void
    {
        $fs = new Filesystem();
        $fs->deleteDirectory($this->tempDir);
    }

    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            WorkshopServiceProvider::class,
            PatternServiceProvider::class
        ];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $config = $app->get('config');
        $config->set('app.name', 'testApp');
        $config->set('view.paths', array_merge($config->get('view.paths'), [$this->tempDir]));
        $config->set('workshop.uri', 'workshop');
        $config->set('workshop.basePath', $this->tempDir);
        $config->set('workshop.patternPath', $this->tempDir . '/patterns');
    }
}