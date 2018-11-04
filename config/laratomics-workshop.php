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
    'uri' => env('LARATOMICS_URI','workshop'),

    /*
    |--------------------------------------------------------------------------
    | Pattern folder path
    |--------------------------------------------------------------------------
    | Here you configure the resources path where your patterns are stored.
    */
    'patternPath' => resource_path(env('LARATOMICS_PATTERN_PATH', 'laratomics/patterns'))

];