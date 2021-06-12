<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(static function(){   
    Route::post('/register', [AuthController::class, 'Register'])->name('register');
    Route::post('/login', [AuthController::class, 'Login'])->name('login');

    //authenticated routes
    Route::middleware('auth:sanctum')->group(static function(){
        Route::prefix('users')->name('user.')->group(static function(){
            Route::get('/{id}', [UserController::class, 'userDetails'])->name('userDetails');
            Route::patch('/{id}', [UserController::class, 'updateUser'])->name('updateUser');
            Route::delete('/{id}', [UserController::class, 'deleteUser'])->name('deleteUser');
        });
    });
});