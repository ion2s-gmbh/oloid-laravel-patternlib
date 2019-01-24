<?php

namespace Unit\Console\Commands;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Tests\BaseTestCase;

class CleanCommandTest extends BaseTestCase
{
    /**
     * @test
     * @covers \Oloid\Console\Commands\CleanCommand
     */
    public function it_should_remove_the_packages_resources_folder()
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
     * @covers \Oloid\Console\Commands\CleanCommand
     */
    public function it_should_abort_removal_of_the_packages_resource_folder()
    {
        // arrange
        $this->assertTrue(File::exists($this->tempDir));

        // act
        $path = config('workshop.basePath');
        $this->artisan('workshop:clean')
            ->expectsQuestion("Are you sure, you want to remove all created patterns ({$path}) from your project?", false)
            ->assertExitCode(-1);

        // assert
        $this->assertTrue(File::exists($this->tempDir . '/patterns'));
    }
}