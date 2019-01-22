<?php

namespace Integration\Http\Controllers;

use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Tests\BaseTestCase;
use Tests\Traits\TestStubs;

class DependenciesControllerTest extends BaseTestCase
{
    use TestStubs;

    /**
     * @test
     * @covers \Laratomics\Http\Controllers\DependenciesController
     */
    public function it_should_return_empty_global_dependencies()
    {
        // arrange

        /** @var TestResponse $response */
        $response = $this->getJson("workshop/api/v1/dependencies");

        // assert
        $response->assertSuccessful();
        $expectedJson = [
            'data' => [
                'styles' => [],
                'scripts' => [],
            ]
        ];
        $response->assertJson($expectedJson);
    }

    /**
     * @test
     * @covers \Laratomics\Http\Controllers\DependenciesController
     */
    public function it_should_return_global_dependencies()
    {
        // arrange
        $this->prepareDependenciesStub();

        /** @var TestResponse $response */
        $response = $this->getJson("workshop/api/v1/dependencies");

        // assert
        $response->assertSuccessful();
        $expectedJson = [
            'data' => [
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
                ],
            ]
        ];
        $response->assertJson($expectedJson);
    }

    /**
     * @test
     * @covers \Laratomics\Http\Controllers\DependenciesController
     */
    public function it_should_add_a_global_dependency()
    {
        $dependencyPath = "{$this->tempDir}/dependencies.json";
        $this->assertFalse(File::exists($dependencyPath));

        // act
        $response = $this->postJson('workshop/api/v1/dependencies', [
            'dependency' => '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,600">'
        ]);

        // assert
        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertTrue(File::exists($dependencyPath));

        $dependencies = File::get($dependencyPath);
        $expectedDependencies = [
                'styles' => [
                    [
                        'src' => 'https://fonts.googleapis.com/css?family=Nunito:200,600',
                        'integrity' => null,
                        'crossorigin' => null
                    ]
                ],
                'scripts' => [],
            ];
        $this->assertEquals($expectedDependencies, json_decode($dependencies, true));
    }

    /**
     * @test
     * @covers \Laratomics\Http\Controllers\DependenciesController
     */
    public function it_should_remove_a_global_dependency()
    {
        // arrange
        $this->prepareDependenciesStub();

        // act
        $response = $this->deleteJson('workshop/api/v1/dependencies', [
            'type' => 'styles',
            'url' => 'https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css'
        ]);

        // assert
        $response->assertSuccessful();
    }

    /**
     * @test
     * @covers \Laratomics\Http\Controllers\DependenciesController
     */
    public function it_should_get_an_error_if_dependency_does_not_exist()
    {
        // act
        $response = $this->deleteJson('workshop/api/v1/dependencies', [
            'type' => 'styles',
            'url' => 'https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css'
        ]);

        // assert
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
