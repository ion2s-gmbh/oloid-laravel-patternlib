<?php

return [
    /*
    |--------------------------------------------------------------------------
    | URI to the workshop GUI
    |--------------------------------------------------------------------------
    | Here you can configure the URI to the workshop GUI
    | Examples:
    |     http://<your-domain>/workshop
    |     http://<your-domain>/patterns
    */
    'uri' => env('WORKSHOP_URI', 'workshop'),

    /*
    |--------------------------------------------------------------------------
    | Package base path
    |--------------------------------------------------------------------------
    | This is the base path where all package specific files and folders are
    | stored.
    */
    'basePath' => resource_path(env('WORKSHOP_BASE_PATH', 'laratomics')),

    /*
    |--------------------------------------------------------------------------
    | Pattern folder path
    |--------------------------------------------------------------------------
    | Here you configure the path where your patterns are stored. This should be
    | a subdirectory of the package's basePath.
    */
    'patternPath' => resource_path(env('WORKSHOP_PATTERN_PATH', 'laratomics/patterns')),

    /*
    |--------------------------------------------------------------------------
    | Global dependencies file
    |--------------------------------------------------------------------------
    | The name of the file, that contains global dependencies like fonts, styles
    | and javascript libs loaded via a CDN.
    */
    'dependenciesFile' => 'dependencies.json'

];