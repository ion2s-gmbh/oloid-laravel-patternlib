<?php


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
    function slash_path($path): string {
        return str_replace('.', '/', $path);
    }
}