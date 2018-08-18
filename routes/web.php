<?php

Route::get('/', function () { return view('index'); })->middleware('auth');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('test', 'TestController@index');
Auth::routes();
