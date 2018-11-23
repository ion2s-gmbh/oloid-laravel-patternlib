<?php

namespace Tests\Integration\Http\Controllers;

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
        $this->preparePatternStub();

        // act
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
        $response = $this->get("/workshop/preview/{$this->name}");

        // assert
        $response->assertSuccessful(200);
        $response->assertViewIs('workshop::preview');
        $response->assertSee('Testing');
        $response->assertViewHas('preview', "<!-- atoms.text.headline1 -->\n<h1>Testing</h1>");
    }
}
