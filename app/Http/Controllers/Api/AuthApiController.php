<?php

namespace App\Http\Controllers\Api;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use JWTAuth;

class AuthApiController extends Controller
{
    //register api
    public function register(Request $request){

        // generates token when password is hashed
        //  $user = User::create($request->all());

        //Validate data
        $data = $request->only('name', 'email', 'password');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is valid, create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        //User created, return success response
        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user
        ], Response::HTTP_OK);





        // WORKING

        //  User::create([
        //      'name' => 'aopio',
        //      'email' => 'aopio@gmail.com',
        //      'password' => Hash::make('wandie22')
        //  ]);

        // return response()->json([
        //     "message" => "User created successfuly"
        //    ],201);


    }

    // login api
     public function login(Request $request){


        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is validated
        //Crean token
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                	'success' => false,
                	'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
    	return $credentials;
            return response()->json([
                	'success' => false,
                	'message' => 'Could not create token.',
                ], 500);
        }

        $is_user_available = auth()->user();

 		//Token created, return with success response and jwt token
        return response()->json([
            'success' => true,
           'status' => 200,
            'message' => 'User Logged in successfully',
            'data' => [
            'user' => $is_user_available,
            'access_token' =>$token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60]

        ]);





        // $credentials = request(['email', 'password']);


        // if (! $token = auth()->attempt($credentials)) {
        //     return response()->json([
        //         'status' => 400,
        //         'error' => 'Sorry!, Invalid login details'
        //     ], 200);
        // }



        // $is_user_available = auth()->user();
        // if ($is_user_available->exists()) {

        //         return response()->json([
        //             'status' => 200,
        //             'message' => 'User Logged in successfully',
        //             'data' => [
        //                 'user' => $is_user_available,
        //                 'access_token' =>$token,
        //                 'token_type' => 'bearer',
        //                 'expires_in' => auth()->factory()->getTTL() * 60
        //             ]
        //         ], 200);


        // }else{

        //     return response()->json([
        //         'status' => 200,
        //         'msg' => 'Sorry User doesnot exist in our records'
        //     ], 200);
        // }





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
