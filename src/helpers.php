<?php


use Illuminate\Filesystem\Filesystem;
use Laratomics\Exceptions\RenderingException;

if (!function_exists('compile_blade_string')) {
    /**
     * Compiles a string containing Blade content to shippable HTML.
     *
     * @param $value
     * @param array $args
     * @return false|string
     * @throws RenderingException
     */
    function compile_blade_string($value, array $args = array()): string
    {
        $generated = Blade::compileString($value);

        ob_start() and extract($args, EXTR_SKIP);

        // We'll include the view contents for parsing within a catcher
        // so we can avoid any WSOD errors. If an exception occurs we
        // will throw it out to the exception handler.
        try {
            eval('?>' . $generated);
        }

            // If we caught an exception, we'll silently flush the output
            // buffer so that no partially rendered views get thrown out
            // to the client and confuse the user with junk.
        catch (Exception $e) {
            ob_get_clean();
            throw new RenderingException('Preview rendering failed', 0, $e);
        }

        $content = ob_get_clean();

        return $content;
    }
}

if (!function_exists('pattern_path')) {
    /**
     * Returns the absolute path to the patterns directory.
     *
     * @param string $subpath
     * @return \Illuminate\Config\Repository|mixed
     */
    function pattern_path(string $subpath = ''): string
    {
        $path = config('workshop.patternPath');
        if (!empty($subpath)) {
            $path = config('workshop.patternPath') . "/{$subpath}";
        }

        return $path;
    }
}

if (!function_exists('dotted_path')) {
    /**
     * Converts a slash separarted path to the dotted notation.
     * Surrounding slashes and whitespaces will be stripped.
     *
     * E.g. /some/path/to/something/ => some.path.to.something
     *
     * @param $path
     * @return string
     */
    function dotted_path($path): string
    {
        $path = trim($path, "/ \t\n\r\0\x0B");
        return str_replace('/', '.', $path);
    }
}

if (!function_exists('slash_path')) {
    /**
     * Converts a dot separated path to the slash notation.
     * E.g. some.path.to.something => some/path/to/something
     *
     * @param $path
     * @return string
     */
    function slash_path($path): string
    {
        return str_replace('.', '/', $path);
    }
}

if (!function_exists('parent_dir')) {
    /**
     * Given a path to a file/directory, this method returns the path, without the last part.
     * That is the directory path where the file/directory is contained.
     * E.g. /some/path/to/a/file.txt => /some/path/to/a
     *
     * @param $path
     * @return string
     */
    function parent_dir($path): string
    {
        $parts = explode('/', $path);
        array_pop($parts);
        return implode('/', $parts);
    }
}

if (!function_exists('dir_is_empty')) {
    /**
     * This method checks if the given path is empty. It is checked, that there are
     * no files or folders under the given path.
     *
     * @param $path
     * @return bool
     */
    function dir_is_empty($path)
    {
        $fs = new Filesystem();
        $files = $fs->files($path);
        $directories = $fs->directories($path);

        return count($files) === 0
            && count($directories) === 0;
    }
}

if (!function_exists('dir_contains_any')) {
    /**
     * Check if the given directory contains files with a specific extension.
     *
     * @param $directory
     * @param $extension
     * @return bool
     */
    function dir_contains_any($directory, $extension): bool
    {
        $fs = new Filesystem();
        $files = $fs->allFiles($directory);
        if (is_array($files)) {
            foreach ($files as $file) {
                if (ends_with($file, $extension)) {
                    return true;
                }
            }
        }
        return false;
    }
}

if (!function_exists('pattern_root')) {
    /**
     * Get the root of a Pattern.
     * E.g. atoms.buttons.submit => atoms
     *
     * @param $pattern
     * @return mixed
     */
    function pattern_root($pattern): string
    {
        $parts = explode('.', $pattern);
        $root = array_shift($parts);
        return $root;
    }
}

if (!function_exists('remove_empty_branch')) {
    /**
     * Remove a folder branch, that does not contain any blade.php files.
     * This method is implemented recursively.
     *
     * @param $branch
     * @param $rootDir
     */
    function remove_empty_branch($branch, $rootDir)
    {
        $fs = new Filesystem();
        if (str_contains($branch, $rootDir)
            && !dir_contains_any($branch, 'blade.php')) {

            $fs->deleteDirectory($branch);
            remove_empty_branch(parent_dir($branch), $rootDir);
        }
    }
}

if (!function_exists('remove_from_file')) {
    /**
     * This method removed the given $needle from the content of the given $file.
     *
     * @param $needle
     * @param $file
     */
    function remove_from_file($needle, $file) {
        $content = file_get_contents($file);
        $newContent = str_replace("{$needle}", "", $content);
        file_put_contents($file, $newContent);
    }
}