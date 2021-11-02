<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    //register api
    public function register(){
        User::create(
            [
                'name' => 'wwandie',
                'email' => 'wwandieinnocent2@gmail.com',
                'password' => Hash::make('wandie22')
                ]
         );
    }

    // login api

    public function login(){

        $credentials = request()->only(['email','password']);

        $token = auth()->attempt($credentials);
        return $token;

    }






}
