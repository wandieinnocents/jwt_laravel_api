<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// AUTHENTICATION API ROUTES
// create user
Route::post('register','App\Http\Controllers\Api\AuthApiController@register');

//login a user
Route::post('login','App\Http\Controllers\Api\AuthApiController@login');

// Return authenticated user
Route::middleware('auth:api')->get('/me','App\Http\Controllers\Api\AuthApiController@me');

// Logout user api
Route::post('logout','App\Http\Controllers\Api\AuthApiController@logout');

// refresh token
Route::get('refresh', 'App\Http\Controllers\Api\AuthApiController@refresh');



// POSTS API ROUTES  - Index,Store,Update,Delete
Route::resource('/posts','App\Http\Controllers\Api\PostApiControllerr');



