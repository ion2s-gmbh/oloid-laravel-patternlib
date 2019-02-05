<?php

namespace Unit\Console\Commands;

use Mockery;
use Oloid\Services\ConfigurationService;
use Tests\BaseTestCase;

class ReconfigureCommandTest extends BaseTestCase
{
    /**
     * @test
     * @covers \Oloid\Console\Commands\ReconfigureCommand
     */
    public function it_should_not_reconfigure_view_of_laravel_application()
    {
        $this->app->bind(ConfigurationService::class, function () {
            $mock = Mockery::mock(ConfigurationService::class)
                ->shouldReceive('registerViewResources')
                ->andReturn(false)
                ->getMock();
            return $mock;
        });

        $this->artisan('workshop:reconfig')
            ->assertExitCode(-1);
    }

    /**
     * @test
     * @covers \Oloid\Console\Commands\ReconfigureCommand
     */
    public function it_should_reconfigure_view_of_laravel_application()
    {
        $this->app->bind(ConfigurationService::class, function () {
            $mock = Mockery::mock(ConfigurationService::class)
                ->shouldReceive('registerViewResources')
                ->andReturn(true)
                ->getMock();
            return $mock;
        });

        $path = config('workshop.basePath');
        $this->artisan('workshop:reconfig')
            ->expectsOutput("Reset extra view path to {$path}.")
            ->expectsOutput('Creating new pattern path...')
            ->assertExitCode(0);
    }
}