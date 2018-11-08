<?php

namespace Laratomics\Tests\Integration;

use Laratomics\Tests\BaseTestCase;

class PatternControllerTest extends BaseTestCase
{
    /**
     * @test
     * @covers \Laratomics\Http\Controllers\PatternController
     */
    public function it_should_create_a_new_pattern()
    {
        // arrange
        $data = [
            'name' => 'pages.testpage',
            'description' => 'This is a test pattern'
        ];

        $expectedJson = [
            'data' => [
                'name' => 'pages.testpage'
            ]
        ];

        // act
        $response = $this->post('workshop/api/v1/pattern', $data);

        // assert
        $this->assertEquals(201, $response->getStatusCode());
        $response->assertJsonFragment($expectedJson);
    }

//    /**
//     * @test
//     * @covers \Laratomics\Http\Controllers\PatternController
//     */
//    public function it_should_be_an_invalide_request()
//    {
//        // arrange
//
//        // act
//
//        // assert
//        // TODO: implement
//        $this->fail();
//    }
}
