<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function userDetails($id){
        $user = User::find($id);
        if(!$user){
            return $this->notFoundResponse('User not found');
        }

        return $this->successResponse('User details retrieved successfully', $user);
    }
}
