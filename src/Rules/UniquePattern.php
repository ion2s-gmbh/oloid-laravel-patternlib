<?php

namespace Laratomics\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\File;

class UniquePattern implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the pattern is unique. The Pattern is considered
     * to be unique if no blade.php file exists with the given name.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $patternFile = pattern_path(slash_path($value)) . '.blade.php';
        return !File::exists($patternFile);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The pattern ':attribute' must be unique!";
    }
}
