<?php

namespace Laratomics\Tests\Unit;

use Illuminate\Filesystem\Filesystem;
use Laratomics\Tests\BaseTestCase;

class SetupTest extends BaseTestCase
{
    /**
     * @var string
     */
    protected $tempDir = __DIR__ . '/tmp';

    /** @test */
    public function it_should_have_test_directory_and_configs()
    {
        $fs = new Filesystem();
        $this->assertTrue($fs->exists(config('workshop.basePath')));
        $this->assertEquals('workshop', config('workshop.uri'));
        $this->assertEquals(__DIR__ . '/tmp', config('workshop.basePath'));
        $this->assertEquals(__DIR__ . '/tmp/patterns', config('workshop.patternPath'));
    }
}
