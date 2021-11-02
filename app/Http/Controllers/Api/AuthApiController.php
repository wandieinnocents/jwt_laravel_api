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

         $user = User::create($request->all());

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
            "message" => "User Logged in successfuly",
            "data" => $credentials,
            "access_token" => $token,
            "token_type" => 'bearer',
            "expires_in" => auth()->factory()->getTTL() * 60

           ]);

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
