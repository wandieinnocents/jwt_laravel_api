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

// AUTHENTICATION API

// create user route
Route::post('user-create',function (Request $request){

    User::create(
        [
            'name' => 'qwandie',
            'email' => 'qwandieinnocent2@gmail.com',
            'password' => Hash::make('wandie22')
            ]
     );
});

//login a user

Route::post('login', function (Request $request){

    $credentials = request()->only(['email','password']);

    $token = auth()->attempt($credentials);
    return $token;

});


//return logged in user
// user should be logged
// Testing with postaman use  Headers ,
//add key content-type : value : application/json ..
//add other key : Authorization value : Bearer + token (of logged in user)
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



