<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function() {
    return redirect()->route('korea');;
});

Route::get('/report/korea', function () {
    return view('report.korea');
})->name('korea');
Route::get('/report/world', function () {
    return view('report.world');
})->name('world');

Route::post('/report', 'MainController@report');
Route::post('join', 'MainController@join');
Route::post('total', 'MainController@total');


Route::get('isay', function () {
    return view('isay');
});
