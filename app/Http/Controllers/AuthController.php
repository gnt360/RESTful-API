<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class AuthController extends BaseController
{
    public function Register(RegisterRequest $request){
        $request['password'] = Hash::make($request->password);
        $user = User::create($request->all());
        return $this->createdResponse('User successfully created', $user);
    }
}
