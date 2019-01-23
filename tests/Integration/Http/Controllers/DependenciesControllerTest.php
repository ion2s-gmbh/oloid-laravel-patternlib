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
     * @covers \Oloid\Http\Controllers\DependenciesController
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
     * @covers \Oloid\Http\Controllers\DependenciesController
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
                ],
            ]
        ];
        $response->assertJson($expectedJson);
    }

    /**
     * @test
     * @covers \Oloid\Http\Controllers\DependenciesController
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
                    'e057686a09b387a9e5b9a1886763ec31' => [
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
     * @covers \Oloid\Http\Controllers\DependenciesController
     */
    public function it_should_throw_validation_exception_on_malformed_dependency()
    {
        // arrange

        // act
        $response = $this->postJson('workshop/api/v1/dependencies', [
            'dependency' => 'https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css'
        ]);

        // assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     * @covers \Oloid\Http\Controllers\DependenciesController
     */
    public function it_should_remove_a_global_dependency()
    {
        // arrange
        $this->prepareDependenciesStub();

        // act
        $response = $this->deleteJson('workshop/api/v1/dependencies', [
            'type' => 'styles',
            'hash' => '7c6d7f6528dd5848ebc15c7ab14de532'
        ]);

        // assert
        $response->assertSuccessful();
    }

    /**
     * @test
     * @covers \Oloid\Http\Controllers\DependenciesController
     */
    public function it_should_get_an_error_if_dependency_does_not_exist()
    {
        // act
        $response = $this->deleteJson('workshop/api/v1/dependencies', [
            'type' => 'styles',
            'hash' => '84c829e356071cb73726c65596dd26cd'
        ]);

        // assert
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
