<?php

namespace Integration\Http\Controllers;

use Illuminate\Foundation\Testing\TestResponse;
use Tests\BaseTestCase;
use Tests\Traits\TestStubs;

class StatusListControllerTest extends BaseTestCase
{
    use TestStubs;

    /**
     * @test
     * @covers \Laratomics\Http\Controllers\StatusListController
     */
    public function it_should_return_patterns_grouped_by_status()
    {
        // arrange
        $this->preparePatternStub();

        /** @var TestResponse $response */
        $response = $this->getJson("workshop/api/v1/status-list");

        // assert
        $response->assertSuccessful();
        $expectedJson = [
            'data' => [
                'todo' => ['atoms.buttons.button'],
                'review' => ['atoms.text.headline1'],
                'rejected' => ['atoms.text.headline2'],
                'done' => ['homepage']
            ]
        ];
        $response->assertJson($expectedJson);
    }
}
