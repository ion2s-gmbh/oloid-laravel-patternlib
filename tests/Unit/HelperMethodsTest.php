<?php


namespace Unit;


use Exception;
use Laratomics\Tests\BaseTestCase;
use Laratomics\Tests\Traits\TestStubs;

class HelperMethodsTest extends BaseTestCase
{
    use TestStubs;

    /**
     * @test
     * @covers ::compileBladeString
     */
    public function it_should_parse_a_php_template_to_html()
    {
        // arrange
        $template = '<h1>{{ $text }}</h1>';

        // act
        try {
            $html = compileBladeString($template, ['text' => 'TEST']);
            $this->assertEquals('<h1>TEST</h1>', $html);
        } catch (Exception $e) {
            $this->fail();
        }
    }

    /**
     * @test
     * @covers ::pattern_path
     */
    public function it_should_return_the_pattern_base_path()
    {
        $this->preparePatternStub();

        // assert
        $expectedPatternPath = realpath(__DIR__ . '/../tmp/patterns');
        $this->assertEquals($expectedPatternPath, pattern_path());
    }

    /**
     * @test
     * @covers ::pattern_path
     */
    public function it_should_return_a_subpath_within_the_patttern_path()
    {
        // arrange
        $this->preparePatternStub();

        // assert
        $expectedPatternPath = realpath(__DIR__ . '/../tmp/patterns/atoms');
        $this->assertEquals($expectedPatternPath, pattern_path('atoms'));
    }
}