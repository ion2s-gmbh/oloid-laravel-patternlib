<?php

use Illuminate\Support\Facades\Route;

Route::post('pattern', 'PatternController@store')
    ->name('store-pattern');

//Route::get('{pattern}', 'PreviewController@preview')
//    ->name('preview-pattern');

Route::get('preview/{pattern}', 'PreviewController@getPreview')
    ->name('get-preview');

Route::get('ping', 'PatternController@ping');