<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){
        $user = User::where('personal_id', $request->personal_id)->first();

        if($user && $user->status == 'აქტიური' && Hash::check($request->password, $user->password)){
            $token = $user->createToken('login_token')->plainTextToken;

            return response()->json([
                'message' => 'Success',
                'user' => $user->makeHidden('menuPermission'),
                'menu' => $user->menuItems(),
                'dashboardable' => $user->role == 1 ? false : true,
                'token' => $token
            ], 200);
        }

        return response()->json([
            'message' => 'თქვენი შეყვანილი მონაცემები არ ემთხვევა ჩვენს ხელთ არსებულს!'
        ], 401);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Success'
        ], 200);
    }
}
