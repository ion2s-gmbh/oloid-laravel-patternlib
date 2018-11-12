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
        $pattern->markup = '<h1>{{ $text }}</h1>';
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
                'type' => 'atom',
                'description' => 'This is a test description',
                'status' => 'TODO',
                'usage' => '',
                'markup' => '<h1>{{ $text }}</h1>',
                'html' => '<h1>Heading 1</h1>',
                'sass' => 'h1 { color: red; }'
            ]
        ];
        $result = $this->cut->toArray($this->pattern);

        $this->assertEquals($expected, $result);
    }
}
