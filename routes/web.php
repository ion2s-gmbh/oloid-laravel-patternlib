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

/*
|--------------------------------------------------------------------------
| GET /preview/{pattern}
|--------------------------------------------------------------------------
| Get the acutal preview of a Pattern that is displayed in an iframe.
*/
Route::get('preview/{pattern}', 'PatternController@getPreview');