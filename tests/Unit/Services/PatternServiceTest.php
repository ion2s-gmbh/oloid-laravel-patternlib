<?php

namespace Tests\Unit\Services;

use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Laratomics\Services\PatternService;
use Laratomics\Tests\BaseTestCase;
use Spatie\YamlFrontMatter\Document;

class PatternServiceTest extends BaseTestCase
{
    /**
     * @var string
     */
    private $name = 'atoms.text.h1';

    /**
     * @var string
     */
    private $description = 'h1 test pattern';

    /**
     * @var PatternService
     */
    private $cut;

    /**
     * @var Filesystem
     */
    private $fs;

    protected function setUp()
    {
        parent::setUp();
        $this->cut = new PatternService();
        $this->fs = new Filesystem();
    }

    /**
     * @test
     * @covers \Laratomics\Services\PatternService
     */
    public function it_should_create_a_blade_template_file()
    {
        $content = $this->cut->createBladeFile($this->name);

        // assert
        $this->assertBladeFileCreation();
        $this->assertTemplateContent($content);
    }

    /**
     * @test
     * @covers \Laratomics\Services\PatternService
     */
    public function it_should_create_a_markdown_file()
    {
        $content = $this->cut->createMarkdownFile($this->name, $this->description);

        // assert
        $this->assertMarkdownFileCreation();
        $this->assertMarkdownContent($content);
    }

    /**
     * @test
     * @covers \Laratomics\Services\PatternService
     */
    public function it_should_create_a_sass_file()
    {
        $content = $this->cut->createSassFile($this->name);

        // assert
        $this->assertSassFileCreation();
        $this->assertEquals("/* {$this->name} */", $content);
    }

    /**
     * @test
     * @covers \Laratomics\Services\PatternService
     */
    public function it_should_create_all_required_pattern_files()
    {
        // act
        $pattern = $this->cut->createPattern($this->name, $this->description);

        $this->assertEquals($this->name, $pattern->name);
        $this->assertEquals("<!-- {$this->name} -->", $pattern->template);
        $this->assertMarkdownContent($pattern->markdown);
        $this->assertEquals("/* {$this->name} */", $pattern->sass);

        // assert
        $this->assertBladeFileCreation();
        $this->assertMarkdownFileCreation();
        $this->assertSassFileCreation();
    }

    /**
     * Asserting that the Pattern's blade file was created.
     */
    protected function assertBladeFileCreation(): void
    {
        try {
            $bladeFile = config('workshop.patternPath') . '/atoms/text/h1.blade.php';
            $this->assertTrue($this->fs->isFile($bladeFile));
            $content = $this->fs->get($bladeFile);
            $this->assertTemplateContent($content);
        } catch (FileNotFoundException $e) {
            $this->fail($e->getMessage());
        }
    }

    /**
     * Asserting that the Pattern's markdown file was created.
     */
    protected function assertMarkdownFileCreation(): void
    {
        try {
            $markdownFile = config('workshop.patternPath') . '/atoms/text/h1.md';
            $this->assertTrue($this->fs->isFile($markdownFile));
            $markdown = $this->fs->get($markdownFile);
            $this->assertMarkdownContent($markdown);
        } catch (FileNotFoundException $e) {
            $this->fail();
        }
    }

    /**
     * Asserting that the Pattern's blade file was created.
     */
    protected
    function assertSassFileCreation(): void
    {
        try {
            $sassFile = config('workshop.patternPath') . '/atoms/text/h1.scss';
            $this->assertTrue($this->fs->isFile($sassFile));
            $sassContent = $this->fs->get($sassFile);
            $this->assertSassContent($sassContent);

            /*
             * Assert that created sass file is imported in the parent sass file
             */
            $parentSassFile = config('workshop.patternPath') . '/atoms/atoms.scss';
            $this->assertTrue($this->fs->isFile($parentSassFile));
            $parentSassContent = $this->fs->get($parentSassFile);
            $this->assertEquals('@import "text/h1";', $parentSassContent);

            /*
             * Assert that the parent sass file is imported in the main sass file
             */
            $mainSassFile = config('workshop.patternPath') . '/patterns.scss';
            $this->assertTrue($this->fs->isFile($mainSassFile));
            $mainSassContent = $this->fs->get($mainSassFile);
            $this->assertEquals('@import "atoms/atoms";', $mainSassContent);
        } catch (FileNotFoundException $e) {
            $this->fail();
        }
    }

    /**
     * Assert that the template content is equal.
     *
     * @param $content
     */
    protected function assertTemplateContent($content): void
    {
        $this->assertEquals("<!-- {$this->name} -->", $content);
    }

    /**
     * @param $markdown
     */
    protected function assertMarkdownContent($markdown): void
    {
        $markdownContent = str_replace('   ', '',
            "---
            status: TODO
            values:
            ---
            {$this->description}");
        $this->assertEquals($markdownContent, $markdown);
    }

    /**
     * @param $sassContent
     */
    protected function assertSassContent($sassContent): void
    {
        $this->assertEquals("/* {$this->name} */", $sassContent);
    }

    /**
     * @test
     * @covers \Laratomics\Services\PatternService
     */
    public function it_should_load_a_pattern_template()
    {
        // arrange
        $this->preparePattern();

        // act
        $content = '';
        try {
            $content = $this->cut->loadBladeFile($this->name);
        } catch (FileNotFoundException $e) {
            $this->fail($e->getMessage());
        }

        // assert
        $this->assertTemplateContent($content);
    }

    /**
     * @test
     * @covers \Laratomics\Services\PatternService
     */
    public function it_should_load_a_markdown_file()
    {
        // arrange
        $this->preparePattern();

        // act
        $content = '';
        try {
            $content = $this->cut->loadMarkdownFile($this->name);
        } catch (FileNotFoundException $e) {
            $this->fail($e->getMessage());
        }

        // assert
        $this->assertMarkdownContent($content);
    }

    /**
     * @test
     * @covers \Laratomics\Services\PatternService
     */
    public function it_should_load_a_sass_file()
    {
        // arrange
        $this->preparePattern();

        // act
        $content = '';
        try {
            $content = $this->cut->loadSassFile($this->name);
        } catch (FileNotFoundException $e) {
            $this->fail($e->getMessage());
        }

        // assert
        $this->assertSassContent($content);
    }

    /**
     * @test
     * @covers \Laratomics\Services\PatternService
     */
    public function it_should_load_a_whole_pattern()
    {
        // arrange
        $this->preparePattern();

        // act
        try {
            $pattern = $this->cut->loadPattern($this->name, []);
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }

        // assert
        $this->assertTemplateContent($pattern->template);
        $this->assertMarkdownContent($pattern->markdown);
        $this->assertSassContent($pattern->sass);
        $this->assertInstanceOf(Document::class, $pattern->metadata);
        $this->assertEquals('DONE', $pattern->state);
    }

    /**
     * Prepare a whole Pattern file structure for the test.
     * @todo refactor using a stub.
     */
    private function preparePattern()
    {
        $this->cut->createPattern($this->name, $this->description);
    }
}
