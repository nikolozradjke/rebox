<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\InstitutionController;
use App\Http\Controllers\Admin\IdeaController as Ideas;

use App\Http\Controllers\Beneficiary\IdeaController;

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
        //როლები
        Route::group(['prefix' => 'roles'], function(){
            Route::get('/', [RoleController::class, 'index']);
            Route::get('/menu', MenuController::class);
            Route::get('/columns', [RoleController::class, 'getColumns']);
            Route::post('/store', [RoleController::class, 'store']);
            Route::get('/show/{role}', [RoleController::class, 'show']);
            Route::put('/update/{role}', [RoleController::class, 'update']);
            Route::delete('/delete/{role}', [RoleController::class, 'delete']);
        });
        //დაწესებულებები
        Route::group(['prefix' => 'institutions'], function(){
            Route::get('/', [InstitutionController::class, 'index']);
            Route::get('/columns', [InstitutionController::class, 'getColumns']);
            Route::post('/store', [InstitutionController::class, 'store']);
            Route::get('/show/{institution}', [InstitutionController::class, 'show']);
            Route::put('/update/{institution}', [InstitutionController::class, 'update']);
            Route::delete('/delete/{institution}', [InstitutionController::class, 'delete']);
        });
        //იდეები და შემოთავაზებები
        Route::group(['prefix' => 'ideas'], function(){
            Route::get('/', [Ideas::class, 'index']);
            Route::get('/show/{idea}', [Ideas::class, 'show']);
        });
    });

    //ბენეფიციარის სივრცე
    Route::middleware('beneficiary')->prefix('beneficiary')->group(function(){
        //იდეები და შემოთავაზებები
        Route::group(['prefix' => 'ideas-and-suggestions'], function(){
            Route::get('/columns', [IdeaController::class, 'getColumns']);
            Route::post('/store', [IdeaController::class, 'store']);
            Route::get('/show/{idea}', [IdeaController::class, 'show']);
            Route::put('/update/{idea}', [IdeaController::class, 'update']);
            Route::delete('/delete/{idea}', [IdeaController::class, 'delete']);
        });
    });
});
