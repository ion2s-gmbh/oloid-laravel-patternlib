<?php

use Illuminate\Support\Facades\Route;

Route::get('info', 'ApplicationController@info');

Route::post('pattern', 'PatternController@store');

//Route::get('{pattern}', 'PreviewController@preview')
//    ->name('preview-pattern');

Route::get('preview/{pattern}', 'PreviewController@getPreview');

