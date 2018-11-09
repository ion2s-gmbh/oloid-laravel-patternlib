<?php

namespace Unit\Console\Commands;

use Laratomics\Services\ConfigurationService;
use Laratomics\Tests\BaseTestCase;
use Mockery;

class ReconfigureCommandTest extends BaseTestCase
{
    /**
     * @test
     * @covers \Laratomics\Console\Commands\ReconfigureCommand
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
     * @covers \Laratomics\Console\Commands\ReconfigureCommand
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
            ->assertExitCode(0);
    }
}