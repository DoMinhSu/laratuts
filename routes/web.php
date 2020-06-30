<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//The Basics
    //Rounting
    //Những route này cung cấp các tính năng liên quan về middleware group, session state and CSRF protection
    //RouteServiceProvider defined for route
Route::get('/hello', 'HelloController@index');