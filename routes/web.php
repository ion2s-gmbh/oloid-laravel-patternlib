<?php

use Illuminate\Support\Facades\Route;

Route::get(config('/'), function () {
    return view('laratomics-workshop::home');
})->name('workshop');

Route::post('laratomics/publish/{pattern}', 'PublishController@publish')
    ->name('publish');

Route::get('laratomics/create-pattern', 'PatternController@createForm')
    ->name('create-pattern');

Route::post('laratomics/store-pattern', 'PatternController@store')
    ->name('store-pattern');

Route::get('/laratomics/{pattern}', 'PreviewController@previewLocal')
    ->name('preview-pattern');

Route::get('/laratomics/preview/{pattern}', 'PreviewController@getPreview')
    ->name('get-preview');