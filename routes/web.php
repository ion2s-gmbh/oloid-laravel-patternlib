<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| GET /
|--------------------------------------------------------------------------
| This is the base route/view of the workshop package.
*/
Route::get('/', function () {
    return view('workshop::gui');
})->name('workshop');

//Route::get('create-pattern', 'PatternController@createForm')
//    ->name('create-pattern');

//Route::post('store-pattern', 'PatternController@store')
//    ->name('store-pattern');

//Route::get('{pattern}', 'PreviewController@preview')
//    ->name('preview-pattern');

/*
|--------------------------------------------------------------------------
| GET /preview/{pattern}
|--------------------------------------------------------------------------
| Get the acutal preview of a Pattern that is displayed in an iframe.
*/
Route::get('preview/{pattern}', 'PreviewController@getPreview')
    ->name('get-preview');