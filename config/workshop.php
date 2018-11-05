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
    'uri' => env('WORKSHOP_URI','workshop'),

    /*
    |--------------------------------------------------------------------------
    |
    |--------------------------------------------------------------------------
    |
    */
    'basePath' => resource_path(env('WORKSHOP_BASE_PATH', 'laratomics')),

    /*
    |--------------------------------------------------------------------------
    | Pattern folder path
    |--------------------------------------------------------------------------
    | Here you configure the path where your patterns are stored. This should be
    | a subdirectory of the package's basePath.
    */
    'patternPath' => resource_path(env('WORKSHOP_PATTERN_PATH', 'laratomics/patterns'))

];