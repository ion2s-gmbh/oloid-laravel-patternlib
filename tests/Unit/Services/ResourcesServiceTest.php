<?php

namespace Services;

use Illuminate\Support\Facades\File;
use Oloid\Services\ResourcesService;
use Tests\BaseTestCase;
use Tests\Traits\TestStubs;

class ResourcesServiceTest extends BaseTestCase
{
    use TestStubs;

    /**
     * @var ResourcesService
     */
    private $cut;

    protected function setUp()
    {
        parent::setUp();
        $this->cut = new ResourcesService();
    }

    /**
     * @test
     * @covers \Oloid\Services\ResourcesService
     */
    public function it_should_have_empty_globals()
    {
        // assert
        $this->assertEmpty($this->cut->getGlobals('head'));
        $this->assertEmpty($this->cut->getGlobals('body'));
    }

    /**
     * @test
     * @covers \Oloid\Services\ResourcesService
     */
    public function it_should_load_global_dependencies_from_file()
    {
        // arrange
        $this->prepareResourcesStub();

        // act
        $globalsService = new ResourcesService();

        // assert
        $this->assertEquals('<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha256-KsRuvuRtUVvobe66OFtOQfjP8WA2SzYsmm4VPfMnxms=" crossorigin="anonymous"></script>',
            $globalsService->getGlobals('head'));

        $this->assertEquals('', $globalsService->getGlobals('body'));
    }

    /**
     * @test
     * @covers \Oloid\Services\ResourcesService
     */
    public function it_should_return_all_global_dependencies()
    {
        // arrange
        $this->prepareResourcesStub();
        $expected = [
            'head' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha256-KsRuvuRtUVvobe66OFtOQfjP8WA2SzYsmm4VPfMnxms=" crossorigin="anonymous"></script>',
            'body' => ''
        ];

        // act
        $this->cut = new ResourcesService();
        $this->assertEquals($expected, $this->cut->getAll());
    }

    /**
     * @test
     * @covers \Oloid\Services\ResourcesService
     */
    public function it_should_add_a_head_and_a_body_dependency()
    {
        $dependencyPath = "{$this->tempDir}/resources.json";
        $this->assertFalse(File::exists($dependencyPath));

        // act
        $this->cut->store('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/css/bootstrap.css" integrity="sha256-5U3z9K3P17cKgGYxXQA5rBZO5EDju+lgtXG6oDXNbNY=" crossorigin="anonymous" />',
            '<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/js/bootstrap.js" integrity="sha256-K0KkaRh1fs/UYfKcnzBK9G/X7HgzuaeVI1hJPS8Sxs4=" crossorigin="anonymous"></script>');

        // assert
        $this->assertTrue(File::exists($dependencyPath));

        $dependencies = File::get($dependencyPath);
        $expectedDependencies = [
            'head' => '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/css/bootstrap.css" integrity="sha256-5U3z9K3P17cKgGYxXQA5rBZO5EDju+lgtXG6oDXNbNY=" crossorigin="anonymous" />',
            'body' => '<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/js/bootstrap.js" integrity="sha256-K0KkaRh1fs/UYfKcnzBK9G/X7HgzuaeVI1hJPS8Sxs4=" crossorigin="anonymous"></script>'
        ];
        $this->assertEquals($expectedDependencies, json_decode($dependencies, true));
    }
}
