<?php

namespace Tests\Integration\Http\Controllers;

use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\JsonResponse;
use Laratomics\Tests\BaseTestCase;
use Laratomics\Tests\Traits\TestStubs;

class PatternControllerTest extends BaseTestCase
{
    use TestStubs;

    /**
     * @var string
     */
    private $name = 'atoms.text.headline1';

    /**
     * @var string
     */
    private $description = 'That\'s a test';

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
        /** @var TestResponse $response */
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
        /** @var TestResponse $response */
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
        $this->preparePatternStub();

        // act
        /** @var TestResponse $response */
        $response = $this->getJson('workshop/api/v1/atoms.text.headline1');

        // assert
        $expected = [
            'data' => [
                'name' => 'atoms.text.headline1',
                'type' => 'atom',
                'description' => 'Our h1 for testing',
                'status' => 'TODO',
                'usage' => 'text.headline1',
                'template' => "<!-- atoms.text.headline1 -->\n<h1>{{ \$text }}</h1>",
                'html' => "<!-- atoms.text.headline1 -->\n<h1>Testing</h1>",
                'sass' => "/* atoms.text.headline1 */\nh1 {\n  color: red;\n}",
            ]
        ];
        $response->assertSuccessful();
        $response->assertJson($expected);
    }

    /**
     * @test
     * @covers \Laratomics\Http\Controllers\PatternController
     */
    public function it_should_return_404_if_a_pattern_does_not_exist()
    {
        // act
        /** @var TestResponse $response */
        $response = $this->getJson('workshop/api/v1/atoms.not.existing');

        // assert
        $response->assertStatus(404);
    }

    /**
     * @test
     * @covers \Laratomics\Http\Controllers\PatternController
     */
    public function it_should_get_a_html_preview_of_a_pattern()
    {
        // arrange
        $this->preparePatternStub();

        // act
        /** @var TestResponse $response */
        $response = $this->get("/workshop/preview/{$this->name}");

        // assert
        $response->assertSuccessful(200);
        $response->assertViewIs('workshop::preview');
        $response->assertSee('Testing');
        $response->assertViewHas('preview', "<!-- atoms.text.headline1 -->\n<h1>Testing</h1>");
    }

    /**
     * @test
     * @covers \Laratomics\Http\Controllers\PatternController
     */
    public function it_should_remove_a_pattern()
    {
        // arrange
        $this->preparePatternStub();

        // act
        /** @var TestResponse $response */
        $response = $this->deleteJson('workshop/api/v1/atoms.text.headline1');

        // assert
        $response->assertSuccessful();
    }

    /**
     * @test
     * @covers \Laratomics\Http\Controllers\PatternController
     */
    public function it_should_get_404_error_if_nonexistend_pattern_is_deleted()
    {
        // arrange

        // act
        /** @var TestResponse $response */
        $response = $this->deleteJson('workshop/api/v1/not.existing.pattern');

        // assert
        $response->assertStatus(JsonResponse::HTTP_NOT_FOUND);
    }

    /**
     * @test
     * @covers \Laratomics\Http\Controllers\PatternController
     */
    public function it_should_update_the_status_of_a_pattern()
    {
        // arrange
        $this->preparePatternStub();

        $data = [
            'status' => 'TESTED'
        ];

        // act
        /** @var TestResponse $response */
        $response = $this->putJson("workshop/api/v1/pattern/status/{$this->name}", $data);

        // assert
        $response->assertSuccessful();
    }
}
