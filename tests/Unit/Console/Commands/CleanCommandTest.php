<?php

namespace Unit\Console\Commands;

use Illuminate\Filesystem\Filesystem;
use Tests\BaseTestCase;

class CleanCommandTest extends BaseTestCase
{
    /**
     * @test
     * @covers \Laratomics\Console\Commands\CleanCommand
     */
    public function it_should_remove_the_laratomics_resources_folder()
    {
        // arrange
        $fs = new Filesystem();
        $this->assertTrue($fs->exists($this->tempDir));

        // act
        $path = config('workshop.basePath');
        $this->artisan('workshop:clean')
            ->expectsQuestion("Are you sure, you want to remove all created patterns ({$path}) from your project?", true)
            ->assertExitCode(0);

        // assert
        $this->assertFalse($fs->exists($this->tempDir));
    }

    /**
     * @test
     * @covers \Laratomics\Console\Commands\CleanCommand
     */
    public function it_should_abort_removal_of_the_laratomics_resource_folder()
    {
        // arrange
        $fs = new Filesystem();
        $this->assertTrue($fs->exists($this->tempDir));

        // act
        $path = config('workshop.basePath');
        $this->artisan('workshop:clean')
            ->expectsQuestion("Are you sure, you want to remove all created patterns ({$path}) from your project?", false)
            ->assertExitCode(-1);

        // assert
        $this->assertTrue($fs->exists($this->tempDir));
    }
}