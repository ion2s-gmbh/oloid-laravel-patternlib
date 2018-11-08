<?php


namespace Laratomics\Tests;

use Illuminate\Filesystem\Filesystem;
use Laratomics\Providers\PatternServiceProvider;
use Laratomics\WorkshopServiceProvider;
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
    protected function setUp()
    {
        $fs = new Filesystem();
        if (is_dir($this->tempDir)) {
            $fs->deleteDirectory($this->tempDir);
        }
        mkdir($this->tempDir);
        parent::setUp();
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
        $config->set('workshop.uri', 'workshop');
        $config->set('workshop.basePath', $this->tempDir);
        $config->set('workshop.patternPath', $this->tempDir . '/patterns');
    }
}