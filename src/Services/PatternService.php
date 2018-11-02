<?php


namespace Laratomics\Services;


use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Spatie\YamlFrontMatter\YamlFrontMatter;

const INITIAL_STATE = 'TODO';

class PatternService
{
    /**
     * Create a new Pattern
     *
     * @param $name
     */
    public function createPattern($name)
    {
        $parts = explode('.', $name);
        $filename = array_pop($parts);
        $path = implode('/', $parts);
        $filename = "{$filename}.blade.php";

        $content = "<!-- {$name} -->";

        $path = base_path("resources/laratomics/patterns/{$path}");

        if (!File::exists($path)) {
            File::makeDirectory($path, 493, true);
        }

        $path .= '/' . $filename;

        File::put($path, str_replace('        ', '', $content));
    }

    /**
     * Create the markdown file.
     *
     * @param $name
     * @param $description
     * @param string $designFile
     */
    public function createMarkdownFile($name, $description)
    {
        $parts = explode('.', $name);
        $filename = array_pop($parts);
        $path = implode('/', $parts);
        $filename = "{$filename}.md";

        $content = sprintf("---
        status: %s
        values:
        ---
        {$description}", INITIAL_STATE);

        $path = base_path("resources/laratomics/patterns/{$path}");

        if (!File::exists($path)) {
            File::makeDirectory($path, 493, true);
        }

        $path .= '/' . $filename;

        File::put($path, str_replace('        ', '', $content));
    }

    /**
     * Create a sass file for the newly created component
     *
     * @param $name
     */
    public function createSassFile($name)
    {
        $parts = explode('.', $name);
        $filename = array_pop($parts);
        $path = implode('/', $parts);
        $filename = "{$filename}.scss";

        $content = "/* {$filename} */";

        $path = base_path("resources/laratomics/patterns/{$path}");

        if (!File::exists($path)) {
            File::makeDirectory($path, 493, true);
        }
        $path .= '/' . $filename;
        File::put($path, $content);

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
//        $patternStateService = app()->make(PatternStateService::class);

//        $state = $patternStateService->checkRemoteState($section, $component);
        $state = 'DONE';

        $preview = compileBladeString($html, $values);
        return [$html, $preview, $metadata, $style, $state];
    }

}