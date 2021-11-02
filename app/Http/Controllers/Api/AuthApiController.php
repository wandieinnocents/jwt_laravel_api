<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    //register api
    public function register(Request $request){

        // generates token when password is hashed
        //  $user = User::create($request->all());

         User::create([
             'name' => 'opio',
             'email' => 'opio@gmail.com',
             'password' => Hash::make('wandie22')
         ]);

        return response()->json([
            "message" => "User created successfuly"
           ],201);
    }

    // login api
     public function login(){
         $credentials = request()->only(['email','password']);
         $token = auth()->attempt($credentials);

        //  response


           return response()->json([
            'status' => 200,
            'message' => 'User Logged in successfully',
            'data' => [
                'user' => $credentials,
                'access_token' =>$token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]
        ], 200);

        //  return $token;

    }

    public function me(){
        // Testing with postaman use  Headers ,
        //add key content-type : value : application/json ..
        //add other key : Authorization value : Bearer + token (of logged in user)
        return response()->json(auth()->user());


    }

    public function logout(){

        auth()->logout();
       return response()->json(['message' => 'Successfully logged out']);
    }







}
