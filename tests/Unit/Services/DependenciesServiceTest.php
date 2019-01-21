<?php

namespace Services;

use Illuminate\Support\Facades\File;
use Laratomics\Services\DependenciesService;
use Tests\BaseTestCase;
use Tests\Traits\TestStubs;

class DependenciesServiceTest extends BaseTestCase
{
    use TestStubs;

    /**
     * @var DependenciesService
     */
    private $cut;

    protected function setUp()
    {
        parent::setUp();
        $this->cut = new DependenciesService();
    }

    /**
     * @test
     * @covers \Laratomics\Services\DependenciesService
     */
    public function it_should_have_empty_globals()
    {
        // assert
        $this->assertEmpty($this->cut->getGlobals('fonts'));
        $this->assertEmpty($this->cut->getGlobals('styles'));
        $this->assertEmpty($this->cut->getGlobals('scripts'));
    }

    /**
     * @test
     * @covers \Laratomics\Services\DependenciesService
     */
    public function it_should_load_global_dependencies_from_file()
    {
        // arrange
        $this->prepareDependenciesStub();

        // act
        $globalsService = new DependenciesService();

        // assert
        $fonts = $globalsService->getGlobals('fonts');
        $this->assertEquals([
            [
                'src' => 'https://fonts.googleapis.com/css?family=Nunito:200,600',
                'integrity' => null,
                'crossorigin' => null
            ]
        ], $fonts);

        $this->assertEquals([
            [
                'src' => 'https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css',
                'integrity' => 'sha256-l85OmPOjvil/SOvVt3HnSSjzF1TUMyT9eV0c2BzEGzU=',
                'crossorigin' => 'anonymous'
            ]
        ], $globalsService->getGlobals('styles'));

        $this->assertEquals([
            [
                'src' => 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js',
                'integrity' => 'sha256-KsRuvuRtUVvobe66OFtOQfjP8WA2SzYsmm4VPfMnxms=',
                'crossorigin' => 'anonymous'
            ]
        ], $globalsService->getGlobals('scripts'));
    }

    /**
     * @test
     * @covers \Laratomics\Services\DependenciesService
     */
    public function it_should_return_all_global_dependencies()
    {
        // arrange
        $this->prepareDependenciesStub();
        $expected = [
            'fonts' => [
                [
                    'src' => 'https://fonts.googleapis.com/css?family=Nunito:200,600',
                    'integrity' => null,
                    'crossorigin' => null
                ]
            ],
            'styles' => [
                [
                    'src' => 'https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css',
                    'integrity' => 'sha256-l85OmPOjvil/SOvVt3HnSSjzF1TUMyT9eV0c2BzEGzU=',
                    'crossorigin' => 'anonymous'
                ]
            ],
            'scripts' => [
                [
                    'src' => 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js',
                    'integrity' => 'sha256-KsRuvuRtUVvobe66OFtOQfjP8WA2SzYsmm4VPfMnxms=',
                    'crossorigin' => 'anonymous'
                ]
            ]
        ];

        // act
        $this->cut = new DependenciesService();
        $this->assertEquals($expected, $this->cut->getAllGlobals());
    }

    /**
     * @test
     * @covers \Laratomics\Services\DependenciesService
     */
    public function it_should_add_a_style_dependency_with_multiple_attributes()
    {
        $dependencyPath = "{$this->tempDir}/dependencies.json";
        $this->assertFalse(File::exists($dependencyPath));

        // act
        $this->cut->addDependency('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/css/bootstrap.css" integrity="sha256-5U3z9K3P17cKgGYxXQA5rBZO5EDju+lgtXG6oDXNbNY=" crossorigin="anonymous" />');

        // assert
        $this->assertTrue(File::exists($dependencyPath));

        $dependencies = File::get($dependencyPath);
        $expectedDependencies = [
            'fonts' => [],
            'styles' => [
                [
                    'src' => 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/css/bootstrap.css',
                    'integrity' => 'sha256-5U3z9K3P17cKgGYxXQA5rBZO5EDju+lgtXG6oDXNbNY=',
                    'crossorigin' => 'anonymous'
                ]
            ],
            'scripts' => [],
        ];
        $this->assertEquals($expectedDependencies, json_decode($dependencies, true));
    }

    /**
     * @test
     * @covers \Laratomics\Services\DependenciesService
     */
    public function it_should_add_a_script_dependency_with_multiple_attributes()
    {
        $dependencyPath = "{$this->tempDir}/dependencies.json";
        $this->assertFalse(File::exists($dependencyPath));

        // act
        $this->cut->addDependency('<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/js/bootstrap.js" integrity="sha256-K0KkaRh1fs/UYfKcnzBK9G/X7HgzuaeVI1hJPS8Sxs4=" crossorigin="anonymous"></script>');

        // assert
        $this->assertTrue(File::exists($dependencyPath));

        $dependencies = File::get($dependencyPath);
        $expectedDependencies = [
            'fonts' => [],
            'styles' => [],
            'scripts' => [
                [
                    'src' => 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/js/bootstrap.js',
                    'integrity' => 'sha256-K0KkaRh1fs/UYfKcnzBK9G/X7HgzuaeVI1hJPS8Sxs4=',
                    'crossorigin' => 'anonymous'
                ]
            ],
        ];
        $this->assertEquals($expectedDependencies, json_decode($dependencies, true));
    }

    /**
     * @test
     * @covers \Laratomics\Services\DependenciesService
     */
    public function it_should_add_a_script_and_a_style_dependency()
    {
        $dependencyPath = "{$this->tempDir}/dependencies.json";
        $this->assertFalse(File::exists($dependencyPath));

        // act
        $this->cut->addDependency('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/css/bootstrap.css" integrity="sha256-5U3z9K3P17cKgGYxXQA5rBZO5EDju+lgtXG6oDXNbNY=" crossorigin="anonymous" />');
        $this->cut->addDependency('<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/js/bootstrap.js" integrity="sha256-K0KkaRh1fs/UYfKcnzBK9G/X7HgzuaeVI1hJPS8Sxs4=" crossorigin="anonymous"></script>');

        // assert
        $this->assertTrue(File::exists($dependencyPath));

        $dependencies = File::get($dependencyPath);
        $expectedDependencies = [
            'fonts' => [],
            'styles' => [
                [
                    'src' => 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/css/bootstrap.css',
                    'integrity' => 'sha256-5U3z9K3P17cKgGYxXQA5rBZO5EDju+lgtXG6oDXNbNY=',
                    'crossorigin' => 'anonymous'
                ]
            ],
            'scripts' => [
                [
                    'src' => 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/js/bootstrap.js',
                    'integrity' => 'sha256-K0KkaRh1fs/UYfKcnzBK9G/X7HgzuaeVI1hJPS8Sxs4=',
                    'crossorigin' => 'anonymous'
                ]
            ],
        ];
        $this->assertEquals($expectedDependencies, json_decode($dependencies, true));
    }
}
