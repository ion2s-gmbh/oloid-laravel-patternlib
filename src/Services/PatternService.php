<?php


namespace Laratomics\Services;


use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Spatie\YamlFrontMatter\YamlFrontMatter;

const INITIAL_STATE = 'TODO';
const BLADE_EXTENSION = 'blade.php';
const SASS_EXTENSION = 'scss';
const MARKDOWN_EXTENSION = 'md';

class PatternService
{
    /**
     * Create a new Blade file for the Pattern.
     *
     * @param string $pattern
     */
    public function createBladeFile(string $pattern): void
    {
        $file = $this->getFileLocation($pattern, BLADE_EXTENSION);
        $content = "<!-- {$pattern} -->";
        File::put($file, $content);
    }

    /**
     * Create a new Markdown file for the Pattern.
     *
     * @param string $pattern
     * @param string $description
     */
    public function createMarkdownFile(string $pattern, string $description): void
    {
        $file = $this->getFileLocation($pattern, MARKDOWN_EXTENSION);

        $content = sprintf("---
        status: %s
        values:
        ---
        {$description}", INITIAL_STATE);

        File::put($file, str_replace('        ', '', $content));
    }

    /**
     * Create a sass file for the newly created component and import it in parent and main sass files.
     *
     * @param string $pattern
     */
    public function createSassFile(string $pattern): void
    {
        $file = $this->getFileLocation($pattern, SASS_EXTENSION);
        $content = "/* {$pattern} */";
        File::put($file, $content);

        $this->importInParentSassFile($pattern);
    }

    /**
     * Import the generated sass file in the parent sass file.
     *
     * @param string $pattern
     */
    private function importInParentSassFile(string $pattern): void
    {
        $parts = explode('.', $pattern);
        $parent = array_shift($parts);
        $parentSassPath = config('laratomics-workshop.patternPath') . "/{$parent}/{$parent}.scss";
        $includeFile = implode('/', $parts);

        /*
         * Import in sass file in parent sass file
         */
        $content = "\n@import \"{$includeFile}\";";
        if (!File::exists($parentSassPath)) {
            $content = "@import \"{$includeFile}\";";

            $this->importInMainSassFile($parent);
        }

        File::append($parentSassPath, $content);
    }

    /**
     * Import in main sass file
     * @param string $parent
     */
    private function importInMainSassFile(string $parent): void
    {
        File::append(config('laratomics-workshop.patternPath') . '/patterns.scss',
            "\n@import \"{$parent}/{$parent}\";");
    }

    /**
     * @param $pattern
     * @param array $values
     * @return array
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws \Exception
     * @todo refactor
     */
    public function loadPattern($pattern, $values = [])
    {
        $patternPath = str_replace('.', '/', $pattern);
        $patternPath = base_path("resources/laratomics/patterns/{$patternPath}");
        $sassFile = "{$patternPath}.scss";
        $style = '';
        if (File::exists($sassFile)) {
            $style = File::get($sassFile);
        }
        $html = File::get("{$patternPath}.blade.php");
        $markdown = File::get("{$patternPath}.md");
        $metadata = YamlFrontMatter::parse($markdown);

        $values = !is_null($metadata->values) ? $metadata->values : array_merge($values, []);

        $parts = explode('.', $pattern);
        $section = array_shift($parts);
        $component = implode('.', $parts);
        $state = 'DONE';

        $preview = compileBladeString($html, $values);
        return [$html, $preview, $metadata, $style, $state];
    }

    /**
     * Get the full file location (path, filename, extension).
     *
     * @param string $pattern
     * @param string $extension
     * @return string
     */
    private function getFileLocation(string $pattern, string $extension): string
    {
        $parts = explode('.', $pattern);
        $filename = array_pop($parts);
        $subpath = implode('/', $parts);
        $directory = config('laratomics-workshop.patternPath') . "/{$subpath}";

        $this->createIfMissing($directory);

        $fullFilename = "{$filename}.{$extension}";

        $location = "{$directory}/{$fullFilename}";
        return $location;
    }

    /**
     * Check if the given directory exists. If it does not exists, the whole directory path is created.
     *
     * @param $directory
     */
    private function createIfMissing($directory): void
    {
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 493, true);
        }
    }

}