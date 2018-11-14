<?php

namespace Laratomics\Exceptions;

use Exception;
use Throwable;

class RenderingException extends Exception
{

    /**
     * RenderingException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('Preview rendering failed', $code, $previous);
    }
}
