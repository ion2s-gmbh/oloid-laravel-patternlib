<?php

namespace Integration\Http\Resources;

use Mockery;
use Oloid\Http\Resources\PatternResource;
use Oloid\Models\Pattern;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use Tests\BaseTestCase;

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

    protected function setUp(): void
    {
        parent::setUp();

        $pattern = new Pattern();
        $pattern->name = 'atoms.test.element';
        $pattern->template = '<h1>{{ $text }}</h1>';
        $pattern->html = '<h1>Heading 1</h1>';
        $pattern->sass = 'h1 { color: red; }';
        $pattern->values = [
            'title' => 'Testing',
            'todos' => ['a', 'b', 'c']
        ];

        /*
         * Metadata Mock
         */
        $pattern->metadata = Mockery::mock(YamlFrontMatter::class)
            ->shouldReceive('body')
            ->andReturn('This is a test description')
            ->getMock();
        $pattern->metadata->status = 'TODO';
        $pattern->metadata->values = [
            'title' => 'Testing',
            'todos' => [
                'a',
                'b',
                'c'
            ]
        ];

        $this->cut = new PatternResource($pattern);
    }

    /**
     * @test
     * @covers \Oloid\Http\Resources\PatternResource
     */
    public function it_should_respond_with_pattern_representation_as_array()
    {
        $expected = [
            'data' => [
                'name' => 'atoms.test.element',
                'type' => 'atoms',
                'description' => 'This is a test description',
                'status' => 'TODO',
                'usage' => '@atoms(\'test.element\', [\'title\' => \'Testing\', \'todos\' => [\'0\' => \'a\', \'1\' => \'b\', \'2\' => \'c\']])',
                'template' => '<h1>{{ $text }}</h1>',
                'html' => '<h1>Heading 1</h1>',
                'sass' => 'h1 { color: red; }',
                'values' => [
                    'title' => 'Testing',
                    'todos' => ['a', 'b', 'c']
                ],
                'subPatterns' => [
                    'todo' => [],
                    'review' => [],
                    'rejected' => [],
                    'done' => []
                ]
            ]
        ];
        $result = $this->cut->toArray($this->pattern);

        $this->assertEquals($expected, $result);
    }
}
