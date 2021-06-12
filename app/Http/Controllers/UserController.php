<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{
    public function userDetails($id){
        $user = User::find($id);
        if(!$user){
            return $this->notFoundResponse('User not found');
        }

        return $this->successResponse('User details retrieved successfully', $user);
    }

    public function updateUser(Request $request, $id){
        $user = User::find($id);
        if(!$user){
            return $this->notFoundResponse('User not found');
        }
        
        $user->update($request->except('password'));
        return $this->successResponse('User updated successfully', $user);
    }
}
