<?php

use Illuminate\Support\Facades\Route;

Route::get(config('/'), function () {
    return view('workshop::home');
})->name('workshop');

//Route::post('store-pattern', 'PatternController@store')
//    ->name('store-pattern');

//Route::get('{pattern}', 'PreviewController@preview')
//    ->name('preview-pattern');

Route::get('preview/{pattern}', 'PreviewController@getPreview')
    ->name('get-preview');