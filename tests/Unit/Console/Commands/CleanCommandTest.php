<?php

namespace Unit\Console\Commands;

use Illuminate\Filesystem\Filesystem;
use Tests\BaseTestCase;
use Tests\Traits\TestStubs;

class CleanCommandTest extends BaseTestCase
{
    use TestStubs;

    /**
     * @test
     * @covers \Oloid\Console\Commands\CleanCommand
     */
    public function it_should_remove_all_patterns()
    {
        // arrange
        $this->preparePatternStub();

        $fs = new Filesystem();
        $this->assertTrue($fs->exists($this->tempDir . '/patterns'));
        $this->assertNotEmpty($fs->allFiles($this->tempDir));
        $this->assertNotEmpty($fs->directories($this->tempDir . '/patterns'));

        // act
        $path = config('workshop.patternPath');
        $this->artisan('workshop:clean')
            ->expectsQuestion("Are you sure, you want to remove all created patterns ({$path}) from your project?", true)
            ->assertExitCode(0);

        // assert
        $this->assertTrue($fs->exists($this->tempDir . '/patterns'));
        $this->assertEmpty($fs->allFiles($this->tempDir));
        $this->assertEmpty($fs->directories($this->tempDir . '/patterns'));
    }

    /**
     * @test
     * @covers \Oloid\Console\Commands\CleanCommand
     */
    public function it_should_abort_removal_of_the_patterns()
    {
        // arrange
        $this->preparePatternStub();

        $fs = new Filesystem();
        $this->assertTrue($fs->exists($this->tempDir . '/patterns'));
        $this->assertNotEmpty($fs->allFiles($this->tempDir));
        $this->assertNotEmpty($fs->directories($this->tempDir . '/patterns'));

        // act
        $path = config('workshop.patternPath');
        $this->artisan('workshop:clean')
            ->expectsQuestion("Are you sure, you want to remove all created patterns ({$path}) from your project?", false)
            ->assertExitCode(-1);

        // assert
        $this->assertTrue($fs->exists($this->tempDir . '/patterns'));
        $this->assertNotEmpty($fs->allFiles($this->tempDir));
        $this->assertNotEmpty($fs->directories($this->tempDir . '/patterns'));
    }
}