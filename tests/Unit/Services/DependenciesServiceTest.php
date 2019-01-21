<?php

namespace Services;

use Laratomics\Services\DependenciesService;
use Tests\BaseTestCase;
use Tests\Traits\TestStubs;

class DependenciesServiceTest extends BaseTestCase
{
    use TestStubs;

    /**
     * @test
     * @covers \Laratomics\Services\DependenciesService
     */
    public function it_should_have_empty_globals()
    {
        // act
        $globalsService = new DependenciesService();

        // assert
        $this->assertEmpty($globalsService->getGlobals('fonts'));
        $this->assertEmpty($globalsService->getGlobals('styles'));
        $this->assertEmpty($globalsService->getGlobals('scripts'));
    }

    /**
     * @test
     * @covers \Laratomics\Services\DependenciesService
     */
    public function it_should_load_globals_from_file()
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
        $globalsService = new DependenciesService();
        $this->assertEquals($expected, $globalsService->getAllGlobals());
    }
}
