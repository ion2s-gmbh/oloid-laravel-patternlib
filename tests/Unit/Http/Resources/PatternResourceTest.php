<?php

namespace Unit\Http\Resources;

use Illuminate\Http\Request;
use Laratomics\Http\Resources\PatternResource;
use Laratomics\Tests\BaseTestCase;
use Mockery;

class PatternResourceTest extends BaseTestCase
{
    /**
     * @var PatternResource
     */
    private $cut;

    private $mockRequest;

    protected function setUp()
    {
        parent::setUp();

        $this->mockRequest = Mockery::mock(Request::class)
            ->shouldReceive('get')
            ->andReturn('atoms.test.element')
            ->getMock();

        $this->cut = new PatternResource([]);
    }

    /**
     * @test
     * @covers \Laratomics\Http\Resources\PatternResource
     */
    public function it_should_respond_with_pattern_representation_as_array()
    {
        $expected = [
            'name' => 'atoms.test.element'
        ];
        $result = $this->cut->toArray($this->mockRequest);

        $this->assertEquals($expected, $result);
    }
}
