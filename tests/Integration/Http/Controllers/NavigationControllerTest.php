<?php

namespace Tests\Integration\Http\Controllers;

use Laratomics\Tests\BaseTestCase;
use Laratomics\Tests\Traits\TestStubs;

class NavigationControllerTest extends BaseTestCase
{
    use TestStubs;

    /**
     * @test
     * @covers \Laratomics\Http\Controllers\NavigationController
     */
    public function it_should_get_a_html_preview_of_a_pattern()
    {
        // arrange
        $this->preparePatternStub();

        // act
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
        $response = $this->getJson('workshop/api/v1/navi');

        // assert
        $response->assertSuccessful();
        $response->assertJson([]);
    }
}
