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

// create user
Route::post('register','App\Http\Controllers\Api\AuthApiController@register');

//login a user
Route::post('login','App\Http\Controllers\Api\AuthApiController@login');

// Return authenticated user
// Testing with postaman use  Headers ,
//add key content-type : value : application/json ..
//add other key : Authorization value : Bearer + token (of logged in user)
Route::post('login','App\Http\Controllers\Api\AuthApiController@login');

Route::middleware('auth:api')->get('/me',function (){

    return response()->json(auth()->user());

});

// logout user
// user should be logged in
// Testing with postaman use  Headers ,
//add key content-type : value : application/json ..
//add other key : Authorization value : Bearer + token (of logged in user)
Route::post('logout', function (Request $request){

    auth()->logout();
    return response()->json(['message' => 'Successfully logged out']);


});


// Posts Api - Index,Store,Update,Delete
Route::resource('/posts','App\Http\Controllers\Api\PostApiControllerr');



