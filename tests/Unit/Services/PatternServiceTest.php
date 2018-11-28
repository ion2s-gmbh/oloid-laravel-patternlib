<?php

namespace Tests\Unit\Services;

use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Laratomics\Services\PatternService;
use Laratomics\Tests\BaseTestCase;
use Laratomics\Tests\Traits\TestStubs;
use Spatie\YamlFrontMatter\Document;

class PatternServiceTest extends BaseTestCase
{
    use TestStubs;

    /**
     * @var string
     */
    private $name = 'atoms.text.headline1';

    /**
     * @var string
     */
    private $description = 'Our h1 for testing';

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
    public function it_should_create_a_nested_pattern_structure()
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
        $this->assertInstanceOf(Document::class, $pattern->metadata);
    }

    /**
     * @test
     * @covers \Laratomics\Services\PatternService
     * @todo improve this test
     */
    public function it_should_create_an_unnested_pattern_structure()
    {
        // act
        $name = 'unnested';
        $description = 'Unnested pattern';
        $pattern = $this->cut->createPattern($name, $description);

        // assert
        $this->assertEquals($name, $pattern->name);
        $this->assertEquals("<!-- {$name} -->", $pattern->template);
//        $this->assertMarkdownContent($pattern->markdown);
        $this->assertEquals("/* {$name} */", $pattern->sass);
//
        // assert
//        $this->assertBladeFileCreation();
//        $this->assertMarkdownFileCreation();
//        $this->assertSassFileCreation();
//        $this->assertInstanceOf(Document::class, $pattern->metadata);
    }

    /**
     * Asserting that the Pattern's blade file was created.
     */
    protected function assertBladeFileCreation(): void
    {
        try {
            $bladeFile = config('workshop.patternPath') . '/atoms/text/headline1.blade.php';
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
            $markdownFile = config('workshop.patternPath') . '/atoms/text/headline1.md';
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
    protected function assertSassFileCreation(): void
    {
        try {
            $sassFile = config('workshop.patternPath') . '/atoms/text/headline1.scss';
            $this->assertTrue($this->fs->isFile($sassFile));
            $sassContent = $this->fs->get($sassFile);
            $this->assertSassContent($sassContent);

            /*
             * Assert that created sass file is imported in the parent sass file
             */
            $parentSassFile = config('workshop.patternPath') . '/atoms/atoms.scss';
            $this->assertTrue($this->fs->isFile($parentSassFile));
            $parentSassContent = $this->fs->get($parentSassFile);
            $this->assertContains('@import "text/headline1";', $parentSassContent);

            /*
             * Assert that the parent sass file is imported in the main sass file
             */
            $mainSassFile = config('workshop.patternPath') . '/patterns.scss';
            $this->assertTrue($this->fs->isFile($mainSassFile));
            $mainSassContent = $this->fs->get($mainSassFile);
            $this->assertContains('@import "atoms/atoms";', $mainSassContent);
        } catch (FileNotFoundException $e) {
            $this->fail();
        }
    }

    /**
     * Assert that the template content is equal.
     *
     * @param $template
     */
    protected function assertTemplateContent($template): void
    {
        $this->assertEquals("<!-- {$this->name} -->", $template);
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
     * @param $sass
     */
    protected function assertSassContent($sass): void
    {
        $this->assertEquals("/* {$this->name} */", $sass);
    }

    /**
     * @test
     * @covers \Laratomics\Services\PatternService
     */
    public function it_should_load_a_pattern_template()
    {
        // arrange
        $this->preparePattern($this->name, $this->description);

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
        $this->preparePattern($this->name, $this->description);

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
        $this->preparePattern($this->name, $this->description);

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
        $this->preparePatternStub();

        // act
        try {
            $pattern = $this->cut->loadPattern($this->name, []);
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }

        // assert
        $this->assertTemplateContentUsingStub($pattern->template);
        $this->assertMarkdownContentUsingStub($pattern->markdown);
        $this->assertSassContentUsingStub($pattern->sass);
        $this->assertInstanceOf(Document::class, $pattern->metadata);
        $this->assertEquals('TODO', $pattern->metadata->status);
    }

    /**
     * @param $template
     */
    private function assertTemplateContentUsingStub($template)
    {
        $templateContent = "<!-- atoms.text.headline1 -->\n<h1>{{ \$text }}</h1>";
        $this->assertEquals($templateContent, $template);
    }

    /**
     * @param $markdown
     */
    private function assertMarkdownContentUsingStub($markdown)
    {
        $markdownContent = "---\nstatus: TODO\nvalues:\n    text: Testing\n---\n{$this->description}";
        $this->assertEquals($markdownContent, $markdown);
    }

    /**
     * @param $sass
     */
    private function assertSassContentUsingStub($sass)
    {
        $this->assertEquals("/* atoms.text.headline1 */\nh1 {\n  color: red;\n}", $sass);
    }

    /**
     * @test
     * @covers \Laratomics\Services\PatternService
     */
    public function it_should_remove_all_pattern_files_and_empty_folders_of_a_nested_pattern()
    {
        // arrange
        $this->preparePatternStub();

        $fs = new Filesystem();
        $this->assertTrue($fs->exists(pattern_path('/atoms/buttons/button.blade.php')));
        $this->assertTrue($fs->exists(pattern_path('/atoms/buttons/button.md')));
        $this->assertTrue($fs->exists(pattern_path('/atoms/buttons/button.scss')));
        $this->assertTrue($fs->exists(pattern_path('/atoms/buttons')));
        $this->assertTrue($fs->exists(pattern_path('/atoms')));

        // act
        $this->assertTrue($this->cut->remove('atoms.buttons.button'));

        $this->assertFalse($fs->exists(pattern_path('/atoms/buttons/button.blade.php')));
        $this->assertFalse($fs->exists(pattern_path('/atoms/buttons/button.md')));
        $this->assertFalse($fs->exists(pattern_path('/atoms/buttons/button.scss')));
        $this->assertFalse($fs->exists(pattern_path('/atoms/buttons')));
        $this->assertTrue($fs->exists(pattern_path('/atoms')));
        $this->assertTrue($fs->exists(pattern_path()));
        $this->assertTrue($fs->exists(pattern_path('patterns.scss')));
    }

    /**
     * @test
     * @covers \Laratomics\Services\PatternService
     */
    public function it_should_remove_a_1_level_pattern()
    {
        // arrange
        $this->preparePatternStub();

        $fs = new Filesystem();
        $this->assertTrue($fs->exists(pattern_path('homepage.blade.php')));
        $this->assertTrue($fs->exists(pattern_path('homepage.md')));
        $this->assertTrue($fs->exists(pattern_path('homepage.scss')));

        // act
        $this->assertTrue($this->cut->remove('homepage'));

        $this->assertTrue($fs->exists(pattern_path('/atoms/text/headline1.blade.php')));
        $this->assertTrue($fs->exists(pattern_path('/atoms/text/headline1.md')));
        $this->assertTrue($fs->exists(pattern_path('/atoms/text/headline1.scss')));
        $this->assertTrue($fs->exists(pattern_path('/atoms/text')));
        $this->assertTrue($fs->exists(pattern_path('/atoms')));
        $this->assertTrue($fs->exists(pattern_path('/atoms/atoms.scss')));
        $this->assertTrue($fs->exists(pattern_path()));
        $this->assertTrue($fs->exists(pattern_path('patterns.scss')));
        $this->assertFalse($fs->exists(pattern_path('homepage.blade.php')));
        $this->assertFalse($fs->exists(pattern_path('homepage.md')));
        $this->assertFalse($fs->exists(pattern_path('homepage.scss')));
    }

    /**
     * @test
     * @covers \Laratomics\Services\PatternService
     * @expectedException \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function it_should_throw_an_exception_if_an_unexisting_pattern_should_be_deleted()
    {
        // arrange
        $this->preparePatternStub();

        // act
        $this->assertFalse($this->cut->remove('not.existing.pattern'));
    }

    /**
     * @test
     * @covers \Laratomics\Services\PatternService
     */
    public function it_should_remove_a_pattern_and_keep_the_patterns_root_and_parallel_patterns()
    {
        // arrange
        $this->preparePatternStub();
        $atomsScssContent = file_get_contents("{$this->tempDir}/patterns/atoms/atoms.scss");
        $mainScssContent = file_get_contents("{$this->tempDir}/patterns/patterns.scss");

        $fs = new Filesystem();
        $this->assertTrue($fs->exists(pattern_path('/atoms/text/headline1.blade.php')));
        $this->assertTrue($fs->exists(pattern_path('/atoms/text/headline1.md')));
        $this->assertTrue($fs->exists(pattern_path('/atoms/text/headline1.scss')));
        $this->assertTrue($fs->exists(pattern_path('/atoms/text/headline2.blade.php')));
        $this->assertTrue($fs->exists(pattern_path('/atoms/text/headline2.md')));
        $this->assertTrue($fs->exists(pattern_path('/atoms/text/headline2.scss')));
        $this->assertTrue($fs->exists(pattern_path('/atoms/text')));
        $this->assertTrue($fs->exists(pattern_path('/atoms')));
        $this->assertContains('text/headline1', $atomsScssContent);

        // act
        $this->assertTrue($this->cut->remove('atoms.text.headline1'));

        $this->assertFalse($fs->exists(pattern_path('/atoms/text/headline1.blade.php')));
        $this->assertFalse($fs->exists(pattern_path('/atoms/text/headline1.md')));
        $this->assertFalse($fs->exists(pattern_path('/atoms/text/headline1.scss')));
        $this->assertTrue($fs->exists(pattern_path('/atoms/text/headline2.blade.php')));
        $this->assertTrue($fs->exists(pattern_path('/atoms/text/headline2.md')));
        $this->assertTrue($fs->exists(pattern_path('/atoms/text/headline2.scss')));
        $this->assertTrue($fs->exists(pattern_path('/atoms/atoms.scss')));
        $this->assertTrue($fs->exists(pattern_path()));
        $this->assertTrue($fs->exists(pattern_path('patterns.scss')));

        $atomsScssContent = file_get_contents("{$this->tempDir}/patterns/atoms/atoms.scss");
        $mainScssContent = file_get_contents("{$this->tempDir}/patterns/patterns.scss");
        $this->assertNotContains('text/headline1', $atomsScssContent);
        $this->assertContains('text/headline2', $atomsScssContent);
        $this->assertContains('atoms/atoms', $mainScssContent);
    }

    /**
     * @test
     * @covers \Laratomics\Services\PatternService
     */
    public function it_should_remove_deeply_nested_pattern_and_keep_other_branches()
    {
        // arrange
        $this->preparePatternStub();
        $this->preparePattern('atoms.buttons.a.b.cancel', 'Cancel button');
        $this->preparePattern('atoms.buttons.a.b.c.delete', 'Delete button');

        $atomsScssContent = file_get_contents("{$this->tempDir}/patterns/atoms/atoms.scss");
//        $mainScssContent = file_get_contents("{$this->tempDir}/patterns/patterns.scss");

        $fs = new Filesystem();
        $this->assertTrue($fs->exists(pattern_path('/atoms/buttons/a/b/cancel.blade.php')));
        $this->assertTrue($fs->exists(pattern_path('/atoms/buttons/a/b/cancel.md')));
        $this->assertTrue($fs->exists(pattern_path('/atoms/buttons/a/b/cancel.scss')));
        $this->assertContains('buttons/a/b/cancel', $atomsScssContent);

        $this->assertTrue($fs->exists(pattern_path('/atoms/buttons/a/b/c/delete.blade.php')));
        $this->assertTrue($fs->exists(pattern_path('/atoms/buttons/a/b/c/delete.md')));
        $this->assertTrue($fs->exists(pattern_path('/atoms/buttons/a/b/c/delete.scss')));
        $this->assertContains('buttons/a/b/c/delete', $atomsScssContent);

        // act
        $this->assertTrue($this->cut->remove('atoms.buttons.a.b.cancel'));

        // assert
        $atomsScssContent = file_get_contents("{$this->tempDir}/patterns/atoms/atoms.scss");
        $this->assertFalse($fs->exists(pattern_path('/atoms/buttons/a/b/cancel.blade.php')));
        $this->assertFalse($fs->exists(pattern_path('/atoms/buttons/a/b/cancel.md')));
        $this->assertFalse($fs->exists(pattern_path('/atoms/buttons/a/b/cancel.scss')));
        $this->assertNotContains('buttons/a/b/cancel', $atomsScssContent);

        $this->assertTrue($fs->exists(pattern_path('/atoms/buttons/a/b/c/delete.blade.php')));
        $this->assertTrue($fs->exists(pattern_path('/atoms/buttons/a/b/c/delete.md')));
        $this->assertTrue($fs->exists(pattern_path('/atoms/buttons/a/b/c/delete.scss')));
        $this->assertContains('buttons/a/b/c/delete', $atomsScssContent);
    }
}
