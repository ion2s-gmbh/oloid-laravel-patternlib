<?php


use Laratomics\Exceptions\RenderingException;

if (! function_exists('compileBladeString')) {
    /**
     * @param $value
     * @param array $args
     * @return false|string
     * @throws RenderingException
     */
    function compileBladeString($value, array $args = array())
    {
        $generated = Blade::compileString($value);

        ob_start() and extract($args, EXTR_SKIP);

        // We'll include the view contents for parsing within a catcher
        // so we can avoid any WSOD errors. If an exception occurs we
        // will throw it out to the exception handler.
        try
        {
            eval('?>'.$generated);
        }

            // If we caught an exception, we'll silently flush the output
            // buffer so that no partially rendered views get thrown out
            // to the client and confuse the user with junk.
        catch (Exception $e)
        {
            ob_get_clean();
            throw new RenderingException('Preview rendering failed', 0, $e);
        }

        $content = ob_get_clean();

        return $content;
    }
}