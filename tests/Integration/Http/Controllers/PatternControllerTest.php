<?php

namespace Tests\Integration\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Laratomics\Models\Pattern;
use Laratomics\Services\PatternService;
use Laratomics\Tests\BaseTestCase;
use Mockery;

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
        $this->assertEquals(JsonResponse::HTTP_CREATED, $response->getStatusCode());
        $response->assertJson($expectedJson);
    }

    /**
     * @test
     * @covers \Laratomics\Http\Controllers\PatternController
     */
    public function it_should_be_an_invalide_request_name_missing()
    {
        // arrange
        $data = [
            'description' => 'This is a test pattern'
        ];

        // act
        $response = $this->postJson('workshop/api/v1/pattern', $data);

        // assert
        $this->assertEquals(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    /**
     * @test
     * @covers \Laratomics\Http\Controllers\PatternController
     */
    public function it_should_be_an_invalide_request_description_missing()
    {
        // arrange
        $data = [
            'name' => 'pages.testpage'
        ];

        // act
        $response = $this->postJson('workshop/api/v1/pattern', $data);

        // assert
        $this->assertEquals(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    /**
     * @test
     * @covers \Laratomics\Http\Controllers\PatternController
     */
    public function it_should_load_all_pattern_information()
    {
        // arrange
        $pattern = new Pattern();
        $pattern->name = 'atoms.test.element';
        $pattern->template = '<h1>{{ $text }}</h1>';
        $pattern->html = '<h1>Heading 1</h1>';
        $pattern->sass = 'h1 { color: red; }';

        /*
         * Metadata Mock
         */
        $pattern->metadata = Mockery::mock(YamlFrontMatter::class)
            ->shouldReceive('body')
            ->andReturn('This is a test description')
            ->getMock();
        $pattern->metadata->status = 'TODO';

        $this->app->bind(PatternService::class, function () use ($pattern) {
            $mock = Mockery::mock(PatternService::class)
                ->shouldReceive('loadPattern')
                ->andReturn($pattern)
                ->getMock();
            return $mock;
        });

        // act
        $response = $this->getJson('workshop/api/v1/atoms.test.element');

        // assert
        $expected = [
            'data' => [
                'name' => 'atoms.test.element',
                'type' => 'atom',
                'description' => 'This is a test description',
                'status' => 'TODO',
                'usage' => 'test.element',
                'template' => '<h1>{{ $text }}</h1>',
                'html' => '<h1>Heading 1</h1>',
                'sass' => 'h1 { color: red; }'
            ]
        ];
        $response->assertSuccessful();
        $response->assertJson($expected);
    }
}
