<?php


namespace Unit;


use Exception;
use Laratomics\Tests\BaseTestCase;

class TemplateParserTest extends BaseTestCase
{
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
}