<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/logout', [AuthController::class, 'logout']);
    //ადმინკა
    Route::middleware('accessOnMenu')->prefix('dashboard')->group(function(){
        //მოხმარებლების მართვა
        Route::group(['prefix' => 'users'], function(){
            Route::get('/', [UserController::class, 'index']);
            Route::get('/columns', [UserController::class, 'getColumns']);
            Route::post('/store', [UserController::class, 'store']);
            Route::get('/show/{user}', [UserController::class, 'show']);
            Route::put('/update/{user}', [UserController::class, 'update']);
            Route::delete('/delete/{user}', [UserController::class, 'delete']);
        });

    });
});
