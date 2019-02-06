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
    public function it_should_install_workshop_without_extra_view_registration()
    {
        $this->app->bind(ConfigurationService::class, function () {
            $mock = Mockery::mock(ConfigurationService::class)
                ->shouldReceive('registerViewResources')
                ->andReturn(false)
                ->getMock();
            return $mock;
        });
        $this->artisan('workshop:install')
            ->expectsOutput('Creating pattern path...')
            ->expectsOutput('Workshop installed successfully.')
            ->assertExitCode(0);
    }

    /**
     * @test
     * @covers \Oloid\Console\Commands\InstallCommand
     * @covers \Oloid\WorkshopServiceProvider
     */
    public function it_should_install_workshop_with_extra_view_registration()
    {
        $this->app->bind(ConfigurationService::class, function () {
            $mock = Mockery::mock(ConfigurationService::class)
                ->shouldReceive('registerViewResources')
                ->andReturn(true)
                ->getMock();
            return $mock;
        });
        $this->artisan('workshop:install')
            ->expectsOutput('Extra view resources configuration have been added in the project\'s view.php')
            ->expectsOutput('Creating pattern path...')
            ->expectsOutput('Workshop installed successfully.')
            ->assertExitCode(0);
    }
}