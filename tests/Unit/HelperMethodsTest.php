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
     * @covers ::compile_blade_string
     */
    public function it_should_parse_a_php_template_to_html()
    {
        // arrange
        $template = '<h1>{{ $text }}</h1>';

        // act
        try {
            $html = compile_blade_string($template, ['text' => 'TEST']);
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

    /**
     * @test
     * @covers ::directory_is_empty
     */
    public function it_should_check_if_a_given_directory_is_empty()
    {
        // arrange

        // act

        // assert
        $this->markTestIncomplete('Not yet implemented!');
    }

    /**
     * @test
     * @covers ::dotted_path
     */
    public function it_should_convert_a_slash_separated_path_to_dotted_notation()
    {
        // arrange
        $path = '/var/some/test/path/';
        $expected = 'var.some.test.path';
        $this->assertEquals($expected, dotted_path($path));
    }

    /**
     * @test
     * @covers ::slash_path
     */
    public function it_should_convert_a_dot_separated_path_to_slash_notation()
    {
        // arrange
        $dottedPath = 'var.some.test.path';
        $expected = 'var/some/test/path';
        $this->assertEquals($expected, slash_path($dottedPath));
    }

    /**
     * @test
     * @covers ::dir_of
     */
    public function it_should_return_the_directory_where_the_given_file_is_contained()
    {
        // arrange

        // act

        // assert
        $this->markTestIncomplete('Not yet implemented!');
    }
}