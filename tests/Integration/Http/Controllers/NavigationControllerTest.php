<?php

namespace Tests\Integration\Http\Controllers;

use Illuminate\Foundation\Testing\TestResponse;
use Laratomics\Tests\BaseTestCase;
use Laratomics\Tests\Traits\TestStubs;

class NavigationControllerTest extends BaseTestCase
{
    use TestStubs;

    /**
     * @test
     * @covers \Laratomics\Http\Controllers\NavigationController
     */
    public function it_should_return_the_navigation_structure()
    {
        // arrange
        $this->preparePatternStub();

        // act
        /** @var TestResponse $response */
        $response = $this->getJson('workshop/api/v1/navi');

        // assert
        $expected = [
            'data' => [
                [
                    'name' => 'atoms',
                    'path' => 'atoms',
                    'items' => [
                        [
                            'name' => 'buttons',
                            'path' => 'atoms.buttons',
                            'items' => [
                                [
                                    'name' => 'button',
                                    'path' => 'atoms.buttons.button',
                                    'items' => []
                                ]
                            ]
                        ]
                    ],
                ],
                [
                    'name' => 'homepage',
                    'path' => 'homepage',
                    'items' => []
                ]
            ]
        ];
        $response->assertSuccessful();
        $response->assertJson($expected);
    }

    /**
     * @test
     * @covers \Laratomics\Http\Controllers\NavigationController
     */
    public function it_should_return_empty_navi_if_no_patterns_exist()
    {
        /** @var TestResponse $response */
        $response = $this->getJson('workshop/api/v1/navi');

        // assert
        $response->assertSuccessful();
        $response->assertJson([]);
    }
}
