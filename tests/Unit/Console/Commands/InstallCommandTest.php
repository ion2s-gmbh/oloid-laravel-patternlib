<?php

namespace Unit\Console\Commands;

use Mockery;
use Oloid\Services\ConfigurationService;
use Tests\BaseTestCase;

class InstallCommandTest extends BaseTestCase
{
    /**
     * @test
     * @covers \Oloid\Console\Commands\InstallCommand
     * @covers \Oloid\WorkshopServiceProvider
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
            ->expectsOutput('Publishing Workshop Assets...')
            ->expectsOutput('Publishing Workshop Configuration...')
            ->expectsOutput('Workshop installed successfully.')
            ->assertExitCode(0);
    }

    /**
     * @test
     * @covers \Oloid\Console\Commands\InstallCommand
     * @covers \Oloid\WorkshopServiceProvider
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
            ->expectsOutput('Publishing Workshop Assets...')
            ->expectsOutput('Publishing Workshop Configuration...')
            ->expectsOutput('Extra view resources configuration have been added in the project\'s view.php')
            ->expectsOutput('Workshop installed successfully.')
            ->assertExitCode(0);
    }
}