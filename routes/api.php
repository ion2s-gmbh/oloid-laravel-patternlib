<?php

use Illuminate\Support\Facades\Route;
use Oloid\Http\Middleware\CheckPatternStatus;

/*
|--------------------------------------------------------------------------
| GET /info
|--------------------------------------------------------------------------
| Get generic information about the main Laravel app, that should be used or
| displayed in the workshop
*/
Route::get('info', 'ApplicationController@info');

/*
|--------------------------------------------------------------------------
| POST /pattern
|--------------------------------------------------------------------------
| Store a newly created Pattern.
*/
Route::post('pattern', 'PatternController@store');

/*
|--------------------------------------------------------------------------
| PUT /pattern/{pattern}
|--------------------------------------------------------------------------
| Update an existing Pattern.
*/
Route::put('pattern/{pattern}', 'PatternController@update');

/*
|--------------------------------------------------------------------------
| DELETE /pattern/{pattern}
|--------------------------------------------------------------------------
| Route to remove the given Pattern.
*/
Route::delete('pattern/{pattern}', 'PatternController@remove');

/*
|--------------------------------------------------------------------------
| PUT /pattern/status/{pattern}
|--------------------------------------------------------------------------
| Update the status of the Pattern.
*/
Route::put('pattern/status/{pattern}', 'PatternController@status');

/*
|--------------------------------------------------------------------------
| GET /pattern/exists/{pattern}
|--------------------------------------------------------------------------
| Check if a Pattern with this name already exists.
*/
Route::get('pattern/exists/{pattern}', 'PatternController@exists');

/*
|--------------------------------------------------------------------------
| GET /pattern/preview/{pattern}
|--------------------------------------------------------------------------
| Get all all information for the preview screen.
| Except the actual rendered preview, that will be loaded by an iframe.
*/
Route::get('pattern/preview/{pattern}', 'PatternController@preview')
    ->middleware(CheckPatternStatus::class);

/*
|--------------------------------------------------------------------------
| GET /navi
|--------------------------------------------------------------------------
| Get the navigation.
*/
Route::get('navi', 'NavigationController@get');

/*
|--------------------------------------------------------------------------
| GET /status-list
|--------------------------------------------------------------------------
| Get a list with all Patterns grouped by their status.
*/
Route::get('status-list', 'StatusListController@get');

/*
|--------------------------------------------------------------------------
| GET /resources
|--------------------------------------------------------------------------
| Get a list of all global resources.
*/
Route::get('resources', 'ResourcesController@get');

/*
|--------------------------------------------------------------------------
| POST /resources
|--------------------------------------------------------------------------
| Add a new global dependency.
*/
Route::post('resources', 'ResourcesController@store');