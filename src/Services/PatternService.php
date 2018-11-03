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
     * @param $name
     */
    public function createBladeFile($name): void
    {
        $file = $this->getFileLocation($name, BLADE_EXTENSION);
        $content = "<!-- {$name} -->";
        File::put($file, $content);
    }

    /**
     * Create a new Markdown file for the Pattern.
     *
     * @param $name
     * @param $description
     */
    public function createMarkdownFile($name, $description): void
    {
        $file = $this->getFileLocation($name, MARKDOWN_EXTENSION);

        $content = sprintf("---
        status: %s
        values:
        ---
        {$description}", INITIAL_STATE);

        File::put($file, str_replace('        ', '', $content));
    }

    /**
     * Create a sass file for the newly created component
     *
     * @param $name
     */
    public function createSassFile($name)
    {
        $file = $this->getFileLocation($name, SASS_EXTENSION);
        $content = "/* {$name} */";
        File::put($file, $content);

        $this->includeInParentSassFile($name);
    }

    /**
     * Include the generated sass file in the parent sass file.
     *
     * @param $name
     */
    private function includeInParentSassFile($name)
    {
        $parts = explode('.', $name);
        $parent = array_shift($parts);
        $parentSassPath = base_path("resources/laratomics/patterns/{$parent}");
        $parentSassFile = $parent . '.scss';
        $includeFile = implode('/', $parts);
        $parentPath = $parentSassPath . '/' . $parentSassFile;

        /*
         * Import in sass file of category
         */
        $content = "\n@import \"{$includeFile}\";";
        if (!File::exists($parentPath)) {
            $content = "@import \"{$includeFile}\";";

            /*
             * Import in main sass file
             */
            File::append(base_path('resources/laratomics/patterns/patterns.scss'),
                "\n@import \"{$parent}/{$parent}\";");
        }

        File::append($parentPath, $content);
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
     * @param string $name
     * @param string $extension
     * @return string
     */
    private function getFileLocation(string $name, string $extension): string
    {
        $parts = explode('.', $name);
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