<?php

namespace Tests\Integration\Http\Resources;

use Laratomics\Http\Resources\PatternResource;
use Laratomics\Models\Pattern;
use Laratomics\Tests\BaseTestCase;
use Mockery;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class PatternResourceTest extends BaseTestCase
{
    /**
     * @var PatternResource
     */
    private $cut;

    /**
     * @var Pattern
     */
    private $pattern;

    protected function setUp()
    {
        parent::setUp();

        $pattern = new Pattern();
        $pattern->name = 'atoms.test.element';
        $pattern->metadata = Mockery::mock(YamlFrontMatter::class)
            ->shouldReceive('body')
            ->andReturn('This is a test description')
            ->getMock();

        $this->cut = new PatternResource($pattern);
    }

    /**
     * @test
     * @covers \Laratomics\Http\Resources\PatternResource
     */
    public function it_should_respond_with_pattern_representation_as_array()
    {
        $expected = [
            'data' => [
                'name' => 'atoms.test.element',
                'description' => 'This is a test description',
            ]
        ];
        $result = $this->cut->toArray($this->pattern);

        $this->assertEquals($expected, $result);
    }
}
