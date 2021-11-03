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
             'name' => 'aopio',
             'email' => 'aopio@gmail.com',
             'password' => Hash::make('wandie22')
         ]);

        return response()->json([
            "message" => "User created successfuly"
           ],201);
    }

    // login api
     public function login(){
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json([
                'status' => 400,
                'error' => 'Sorry!, Invalid login details'
            ], 200);
        }

        // check if user exists
        $is_user_available = auth()->user();
        if ($is_user_available->exists()) {

                return response()->json([
                    'status' => 200,
                    'message' => 'User Logged in successfully',
                    'data' => [
                        'user' => $is_user_available,
                        'access_token' =>$token,
                        'token_type' => 'bearer',
                        'expires_in' => auth()->factory()->getTTL() * 60
                    ]
                ], 200);


        }else{

            return response()->json([
                'status' => 200,
                'msg' => 'Sorry User doesnot exist in our records'
            ], 200);
        }
        // end of check if user exists




    }

    // return authenticated user
    public function me(){
        // Testing with postaman use  Headers ,
        //add key content-type : value : application/json ..
        //add other key : Authorization value : Bearer + token (of logged in user)
        return response()->json(auth()->user());


    }

    // logout user in the system
    public function logout(){

        auth()->logout();
       return response()->json(['message' => 'Successfully logged out']);
    }

    // refresh token
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    // respond with token
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }






}
