<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//posts
Route::get('/posts','App\Http\Controllers\PostapiController@list');
Route::get('/posts/{id}','App\Http\Controllers\PostapiController@show');
Route::get('/comments/{id}','App\Http\Controllers\CommentapiController@list');
Route::get('/comment/{id}','App\Http\Controllers\CommentapiController@show');

Route::middleware('isapiloggedin')->group(function(){

    Route::post('/posts','App\Http\Controllers\PostapiController@create');
    Route::put('/posts/{id}','App\Http\Controllers\PostapiController@edit');
    Route::delete('/posts/{id}','App\Http\Controllers\PostapiController@destroy');

    //Comments
    Route::post('/comments/{id}','App\Http\Controllers\CommentapiController@create');
    Route::put('/comments/{id}','App\Http\Controllers\CommentapiController@edit');
    Route::delete('/comments/{id}','App\Http\Controllers\CommentapiController@destroy');

    //users
    Route::get('/users','App\Http\Controllers\UserapiController@list');
    Route::get('/users/{id}','App\Http\Controllers\UserapiController@show');
    Route::delete('/users/{id}','App\Http\Controllers\UserapiController@destroy');
});



Route::post('/users/register','App\Http\Controllers\UserapiController@register');
Route::post('/users/login','App\Http\Controllers\UserapiController@login');

