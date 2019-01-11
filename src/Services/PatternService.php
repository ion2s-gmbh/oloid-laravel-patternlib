<?php


namespace Laratomics\Services;


use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;
use Laratomics\Exceptions\RenderingException;
use Laratomics\Models\Pattern;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use SplFileInfo;


class PatternService
{
    const INITIAL_STATE = 'todo';
    const BLADE_EXTENSION = 'blade.php';
    const SASS_EXTENSION = 'scss';
    const MARKDOWN_EXTENSION = 'md';

    /**
     * Crate all required files for the given new Pattern.
     *
     * @param string $name
     * @param string $description
     * @return Pattern
     */
    public function createPattern(string $name, string $description): Pattern
    {
        $pattern = new Pattern();
        $pattern->name = $name;
        $pattern->template = $this->createBladeFile($name);
        $pattern->markdown = $this->createMarkdownFile($name, $description);
        $pattern->metadata = YamlFrontMatter::parse($pattern->markdown);
        $pattern->sass = $this->createSassFile($name);
        return $pattern;
    }

    /**
     * Create a new Blade file for the Pattern.
     *
     * @param string $pattern
     * @return string
     */
    public function createBladeFile(string $pattern): string
    {
        $file = $this->getFileLocation($pattern, self::BLADE_EXTENSION);
        $content = '';
        File::put($file, $content);
        return $content;
    }

    /**
     * Create a new Markdown file for the Pattern.
     *
     * @param string $pattern
     * @param string $description
     * @return string
     */
    public function createMarkdownFile(string $pattern, string $description): string
    {
        $file = $this->getFileLocation($pattern, self::MARKDOWN_EXTENSION);

        $content = sprintf("---
        status: %s
        values:
        ---
        {$description}", self::INITIAL_STATE);
        $content = str_replace('        ', '', $content);
        File::put($file, $content);
        return $content;
    }

    /**
     * Create a sass file for the newly created component and import it in parent and main sass files.
     *
     * @param string $pattern
     * @return string
     */
    public function createSassFile(string $pattern): string
    {
        $file = $this->getFileLocation($pattern, self::SASS_EXTENSION);
        $content = '';
        File::put($file, $content);

        $this->addSassImport($pattern);
        return $content;
    }

    /**
     * Import the generated sass file in the parent sass file.
     *
     * @param string $pattern
     */
    private function addSassImport(string $pattern): void
    {
        $parts = explode('.', $pattern);
        $parent = array_shift($parts);

        if (count($parts) === 0) {
            $import = "{$parent}";
            $this->importInMainSassFile($import);

        } elseif (count($parts) >= 1) {

            $parentSassPath = pattern_path() . "/{$parent}/{$parent}.scss";
            $includeFile = implode('/', $parts);

            /*
             * Import in parent sass file
             */
            $content = "@import \"{$includeFile}\";\n";
            if (!File::exists($parentSassPath)) {

                $import = "{$parent}/{$parent}";
                $this->importInMainSassFile($import);
            }

            File::append($parentSassPath, $content);
        }
    }

    /**
     * Import in main sass file
     * @param string $import
     */
    private function importInMainSassFile(string $import): void
    {
        File::append(pattern_path() . '/patterns.scss',
            "@import \"{$import}\";\n");
    }

    /**
     * @param $name
     * @param array $values
     * @return Pattern
     * @throws FileNotFoundException
     * @throws RenderingException
     */
    public function loadPattern($name, $values = []): Pattern
    {
        $pattern = new Pattern();
        $pattern->name = $name;

        /*
         * Get file paths and check the existens of the whole Pattern
         */
        $pattern->templateFile = $this->getFileLocation($name, self::BLADE_EXTENSION);
        $pattern->sassFile = $this->getFileLocation($name, self::SASS_EXTENSION);
        $pattern->markdownFile = $this->getFileLocation($name, self::MARKDOWN_EXTENSION);

        if (!File::exists($pattern->templateFile)
            || !File::exists($pattern->markdownFile)
            || !File::exists($pattern->sassFile)) {
            throw new FileNotFoundException;
        }

        /*
         * Gathering general path information
         */
        $pattern->mainSassFile = pattern_path('patterns.scss');
        $branchRoot = pattern_root($name);
        $pattern->rootSassFile = pattern_path("{$branchRoot}/{$branchRoot}.scss");

        /*
         * Load Pattern content
         */
        $pattern->template = $this->loadBladeFile($name);
        $markdown = $this->loadMarkdownFile($name);
        $pattern->markdown = $markdown;
        $pattern->metadata = YamlFrontMatter::parse($markdown);
        $pattern->status = $pattern->metadata->status;
        $pattern->sass = $this->loadSassFile($name);

        /*
         * Create the preview
         */
        $pattern->values = !is_null($pattern->metadata->values) ? $pattern->metadata->values : array_merge($values, []);
        $pattern->html = compile_blade_string($pattern);

        return $pattern;
    }

    /**
     * Load the pattern template.
     *
     * @param string $pattern
     * @return string
     * @throws FileNotFoundException
     */
    public function loadBladeFile(string $pattern): string
    {
        $file = $this->getFileLocation($pattern, self::BLADE_EXTENSION);
        return File::get($file);
    }

    /**
     * Load the pattern markdown file.
     *
     * @param string $pattern
     * @return string
     * @throws FileNotFoundException
     */
    public function loadMarkdownFile(string $pattern): string
    {
        $file = $this->getFileLocation($pattern, self::MARKDOWN_EXTENSION);
        return File::get($file);
    }

    /**
     * Load the pattern sass file.
     *
     * @param string $pattern
     * @return string
     * @throws FileNotFoundException
     */
    public function loadSassFile(string $pattern): string
    {
        $file = $this->getFileLocation($pattern, self::SASS_EXTENSION);
        return File::get($file);
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
        $directory = pattern_path($subpath);

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

    /**
     * Remove the given Pattern.
     *
     * @param string $name
     * @return bool
     * @throws FileNotFoundException
     * @throws RenderingException
     */
    public function remove(string $name): bool
    {
        $pattern = $this->loadPattern($name);

        /*
         * Delete base files
         */
        $templateSuccess = File::delete($pattern->templateFile);
        $markdownSuccess = File::delete($pattern->markdownFile);
        $sassSuccess = File::delete($pattern->sassFile);

        /*
         * Remove the path to the Pattern
         */
        $this->removePatternBranch($pattern);

        /*
         * Remove sass import in parent and main sass files
         */
        $this->removeSassImport($pattern);

        return $templateSuccess && $markdownSuccess && $sassSuccess;
    }
    /**
     * Remove path recursevly if directory does not contain any blade files
     * until blade files are found or the Pattern root is reached.
     *
     * @param Pattern $pattern
     */
    private function removePatternBranch(Pattern $pattern): void
    {
        $branchDir = parent_dir($pattern->templateFile);
        $branchRoot = pattern_root($pattern->name);
        $rootDir = pattern_path($branchRoot);
        remove_empty_branch($branchDir, $rootDir);
    }

    /**
     * Remove the import of the Pattern's sass file in the root sass file.
     * If the root sass file was removed, because it is not required any more, than the root
     * sass file must be removed from the main sass file.
     *
     * @param Pattern $pattern
     */
    private function removeSassImport(Pattern $pattern): void
    {
        $branchRoot = pattern_root($pattern->name);
        $parts = explode('/', slash_path($pattern->name));
        array_shift($parts);
        $include = implode('/', $parts);
        if (File::exists($pattern->rootSassFile)) {
            $import = "@import \"{$include}\";\n";
            remove_from_file($import, $pattern->rootSassFile);
        } else {
            $import = "@import \"{$branchRoot}/{$branchRoot}\";\n";
            if (count($parts) === 0) {
                $import = "@import \"{$branchRoot}\";\n";
            }
            remove_from_file($import, $pattern->mainSassFile);
        }
    }

    /**
     * Update the status of a Pattern.
     *
     * @param $newStatus
     * @param string $name
     * @throws FileNotFoundException
     * @throws RenderingException
     */
    public function updateStatus($newStatus, string $name)
    {
        $pattern = $this->loadPattern($name);
        $oldStatus = $pattern->metadata->status;
        $file = $this->getFileLocation($name, self::MARKDOWN_EXTENSION);

        $search = "status: {$oldStatus}";
        $replacement = "status: {$newStatus}";
        $mdContent = $this->loadMarkdownFile($name);
        $newMdContent = str_replace($search, $replacement, $mdContent);
        file_put_contents($file, $newMdContent);
    }

    /**
     * Check if the Pattern exists.
     *
     * @param string $pattern
     * @return bool
     */
    public function exists(string $pattern)
    {
        $patternFile = $this->getFileLocation($pattern, self::BLADE_EXTENSION);
        return File::exists($patternFile);
    }

    /**
     * Update description of a Pattern.
     *
     * @param string $pattern
     * @param $description
     * @throws FileNotFoundException
     */
    public function updateDescription(string $pattern, $description)
    {
        $markdownContent = $this->loadMarkdownFile($pattern);
        $markdown = YamlFrontMatter::parse($markdownContent);
        $currentDescription = trim($markdown->body());

        if (empty($currentDescription)) {
            $newContent = $markdownContent . $description;
        } else {
            $search = "${currentDescription}";
            $newContent = str_replace($search, $description, $markdownContent);
        }

        File::put($this->getFileLocation($pattern, self::MARKDOWN_EXTENSION), $newContent);
    }

    public function rename(string $currentName, $newName): Pattern
    {
        $oldPattern = $this->loadPattern($currentName);

        /*
         * Copy existing pattern files to the new location
         */
        File::move($oldPattern->templateFile, $this->getFileLocation($newName, self::BLADE_EXTENSION));
        File::move($oldPattern->markdownFile, $this->getFileLocation($newName, self::MARKDOWN_EXTENSION));
        File::move($oldPattern->sassFile, $this->getFileLocation($newName, self::SASS_EXTENSION));

        /*
         * Change sass import & pattern structure
         */
        $this->addSassImport($newName);

        $this->removePatternBranch($oldPattern);

        $this->removeSassImport($oldPattern);

        $newPattern = $this->loadPattern($newName);
        $this->updatePatternReferences($oldPattern, $newPattern);

        return $newPattern;
    }

    private function updatePatternReferences(Pattern $oldPattern, Pattern $newPattern)
    {
        $files = File::allFiles(pattern_path());

        /*
         * Get all the templates
         */
        $templates = [];
        foreach ($files as $file) {
            if (ends_with($file->getRelativePathname(), 'blade.php')) {
                $templates[] = $file;
            }
        }

        /*
         * Replace reference in template files
         */
        /** @var SplFileInfo $template */
        foreach ($templates as $template) {
            $content = $template->getContents();

            /*
             * Search and replace directive reference
             */
            $search = "/@{$oldPattern->getType()}\('{$oldPattern->getNameWithoutType()}'/";
            $replacement = "@{$newPattern->getType()}('{$newPattern->getNameWithoutType()}'";
            $newContent = preg_replace($search, $replacement, $content);

            /*
             * Search and replace include reference
             */
            $search = "/@include\('patterns.{$oldPattern->name}'/";
            $replacement = "@include('patterns.{$newPattern->name}'";
            $newContent = preg_replace($search, $replacement, $newContent);

            /*
             * Save contents back to file
             */
            if ($content !== $newContent && !is_null($newContent)) {
                File::put($template->getPathname(), $newContent);
            }
        }
    }
}