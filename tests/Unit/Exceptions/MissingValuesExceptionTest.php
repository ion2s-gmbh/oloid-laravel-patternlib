<?php

namespace Unit\Http\Requests;


use Exception;
use Illuminate\Http\Request;
use Mockery;
use Oloid\Exceptions\MissingValuesException;
use Tests\BaseTestCase;

class MissingValuesExceptionTest extends BaseTestCase
{
    /**
     * @test
     * @covers \Oloid\Exceptions\MissingValuesException
     */
    public function it_should_render_the_exception_as_json()
    {
        // arrange
        $cut = new MissingValuesException('Missing values', 0, new Exception('previous exception'));
        $requestMock = Mockery::mock(Request::class);
        $requestMock->shouldReceive('wantsJson')
            ->andReturnTrue();

        // act
        $response = $cut->render($requestMock);

        $expectedJson = [
            'message' => 'previous exception'
        ];

        // assert
        $this->assertEquals(422, $response->getStatusCode());
        $this->assertJson(json_encode($expectedJson), json_encode($response->getData()));
    }

    /**
     * @test
     * @covers \Oloid\Exceptions\MissingValuesException
     */
    public function it_should_render_the_exception_as_html()
    {
        // arrange
        $cut = new MissingValuesException('Missing values', 0, new Exception('previous exception'));
        $requestMock = Mockery::mock(Request::class);
        $requestMock->shouldReceive('wantsJson')
            ->andReturnFalse();

        // act
        $response = $cut->render($requestMock);

        $expectedJson = [
            'message' => 'previous exception'
        ];

        // assert
        $this->assertJson(json_encode($expectedJson), json_encode($response->getData()));
    }
}
