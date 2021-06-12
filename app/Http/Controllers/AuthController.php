<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;

class AuthController extends BaseController
{
    public function Register(RegisterRequest $request){
        $request['password'] = Hash::make($request->password);
        $user = User::create($request->all());
        return $this->createdResponse('User successfully created', $user);
    }

    public function Login(LoginRequest $request ){
        $user = User::where('email', $request->email)->first();
       
        if (!$user || !Hash::check($request->password, $user->password)) {            
            return $this->validationResponse('credentials does not match');
        }

        $token = $user->createToken('Apiauthentication');
        $user->token = $token->plainTextToken; 
        $userResource = new UserResource($user);
        return $this->successResponse('Successfully logged in', $userResource);
    }
}
