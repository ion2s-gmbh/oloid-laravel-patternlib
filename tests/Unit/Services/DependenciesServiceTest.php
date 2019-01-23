<?php

namespace Services;

use Illuminate\Support\Facades\File;
use Oloid\Services\DependenciesService;
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
     * @covers \Oloid\Services\DependenciesService
     */
    public function it_should_have_empty_globals()
    {
        // assert
        $this->assertEmpty($this->cut->getGlobals('styles'));
        $this->assertEmpty($this->cut->getGlobals('scripts'));
    }

    /**
     * @test
     * @covers \Oloid\Services\DependenciesService
     */
    public function it_should_load_global_dependencies_from_file()
    {
        // arrange
        $this->prepareDependenciesStub();

        // act
        $globalsService = new DependenciesService();

        // assert
        $this->assertEquals([
            '7c6d7f6528dd5848ebc15c7ab14de532' => [
                'src' => 'https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css',
                'integrity' => 'sha256-l85OmPOjvil/SOvVt3HnSSjzF1TUMyT9eV0c2BzEGzU=',
                'crossorigin' => 'anonymous'
            ]
        ], $globalsService->getGlobals('styles'));

        $this->assertEquals([
            '094841b35e7f2d90c081a6f3d18040b4' => [
                'src' => 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js',
                'integrity' => 'sha256-KsRuvuRtUVvobe66OFtOQfjP8WA2SzYsmm4VPfMnxms=',
                'crossorigin' => 'anonymous'
            ]
        ], $globalsService->getGlobals('scripts'));
    }

    /**
     * @test
     * @covers \Oloid\Services\DependenciesService
     */
    public function it_should_return_all_global_dependencies()
    {
        // arrange
        $this->prepareDependenciesStub();
        $expected = [
            'styles' => [
                '7c6d7f6528dd5848ebc15c7ab14de532' => [
                    'src' => 'https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css',
                    'integrity' => 'sha256-l85OmPOjvil/SOvVt3HnSSjzF1TUMyT9eV0c2BzEGzU=',
                    'crossorigin' => 'anonymous'
                ]
            ],
            'scripts' => [
                '094841b35e7f2d90c081a6f3d18040b4' => [
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
     * @covers \Oloid\Services\DependenciesService
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
            'styles' => [
                '84c829e356071cb73726c65596dd26cd' => [
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
     * @covers \Oloid\Services\DependenciesService
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
            'styles' => [],
            'scripts' => [
                'b7dacb8de74b94cf9fbe7fa1c1915bc1' => [
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
     * @covers \Oloid\Services\DependenciesService
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
            'styles' => [
                '84c829e356071cb73726c65596dd26cd' => [
                    'src' => 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/css/bootstrap.css',
                    'integrity' => 'sha256-5U3z9K3P17cKgGYxXQA5rBZO5EDju+lgtXG6oDXNbNY=',
                    'crossorigin' => 'anonymous'
                ]
            ],
            'scripts' => [
                'b7dacb8de74b94cf9fbe7fa1c1915bc1' => [
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
     * @covers \Oloid\Services\DependenciesService
     */
    public function it_should_not_add_an_exact_dependency_twice()
    {
        // arrange
        $this->prepareDependenciesStub();
        $expected = [
            'styles' => [
                '7c6d7f6528dd5848ebc15c7ab14de532' => [
                    'src' => 'https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css',
                    'integrity' => 'sha256-l85OmPOjvil/SOvVt3HnSSjzF1TUMyT9eV0c2BzEGzU=',
                    'crossorigin' => 'anonymous'
                ]
            ],
            'scripts' => [
                '094841b35e7f2d90c081a6f3d18040b4' => [
                    'src' => 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js',
                    'integrity' => 'sha256-KsRuvuRtUVvobe66OFtOQfjP8WA2SzYsmm4VPfMnxms=',
                    'crossorigin' => 'anonymous'
                ]
            ]
        ];

        // act
        $this->cut = new DependenciesService();
        $this->cut->addDependency('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha256-l85OmPOjvil/SOvVt3HnSSjzF1TUMyT9eV0c2BzEGzU=" crossorigin="anonymous" />');

        // assert
        $this->assertEquals($expected, $this->cut->getAllGlobals());
    }

    /**
     * @test
     * @covers \Oloid\Services\DependenciesService
     */
    public function it_should_check_if_a_dependency_with_given_type_exists()
    {
        // arrange
        $this->prepareDependenciesStub();
        $this->cut = new DependenciesService();

        // assert
        $this->assertTrue($this->cut->dependencyExists('styles', '7c6d7f6528dd5848ebc15c7ab14de532'));
        $this->assertFalse($this->cut->dependencyExists('styles', '84c829e356071cb73726c65596dd26cd'));
    }

    /**
     * @test
     * @covers \Oloid\Services\DependenciesService
     */
    public function it_should_remove_a_dependency()
    {
        // arrange
        $this->prepareDependenciesStub();
        $this->cut = new DependenciesService();

        $expected = [
            'styles' => [],
            'scripts' => [
                '094841b35e7f2d90c081a6f3d18040b4' => [
                    'src' => 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js',
                    'integrity' => 'sha256-KsRuvuRtUVvobe66OFtOQfjP8WA2SzYsmm4VPfMnxms=',
                    'crossorigin' => 'anonymous'
                ]
            ]
        ];

        // act
        $this->cut->removeDependency('styles', '7c6d7f6528dd5848ebc15c7ab14de532');

        // assert
        $this->assertEquals($expected, $this->cut->getAllGlobals());
        $json = File::get("{$this->tempDir}/dependencies.json");
        $this->assertEquals($expected, json_decode($json, true));
    }
}
