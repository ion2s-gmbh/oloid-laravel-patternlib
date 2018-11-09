<?php

namespace Unit\Console\Commands;

use Illuminate\Filesystem\Filesystem;
use Laratomics\Services\ConfigurationService;
use Laratomics\Tests\BaseTestCase;
use Mockery;

class InstallCommandTest extends BaseTestCase
{
    /**
     * @test
     * @covers \Laratomics\Console\Commands\CleanCommand
     */
    public function it_should_publish_workshop_resources_and_configs_without_extra_view_registration()
    {
        $this->app->bind(ConfigurationService::class, function () {
            $mock = Mockery::mock(ConfigurationService::class)
                ->shouldReceive('registerViewResources')
                ->andReturn(false)
                ->getMock();
            return $mock;
        });
        $this->artisan('workshop:install')
            ->expectsOutput('Publishing Laratomics Workshop Assets...')
            ->expectsOutput('Publishing Laratomics Workshop Configuration...')
            ->expectsOutput('Laratomics Workshop installed successfully.')
            ->assertExitCode(0);
    }

    /**
     * @test
     * @covers \Laratomics\Console\Commands\InstallCommand
     */
    public function it_should_publish_workshop_resources_and_configs_with_extra_view_registration()
    {
        $this->app->bind(ConfigurationService::class, function () {
            $mock = Mockery::mock(ConfigurationService::class)
                ->shouldReceive('registerViewResources')
                ->andReturn(true)
                ->getMock();
            return $mock;
        });
        $this->artisan('workshop:install')
            ->expectsOutput('Publishing Laratomics Workshop Assets...')
            ->expectsOutput('Publishing Laratomics Workshop Configuration...')
            ->expectsOutput('Extra view resources configuration have been added in the project\'s view.php')
            ->expectsOutput('Laratomics Workshop installed successfully.')
            ->assertExitCode(0);
    }
}