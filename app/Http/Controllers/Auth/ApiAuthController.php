<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    public function store(Request $request)
    {

        $Validator =Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($Validator->fails()) {
            return response()->json(['errors' => $Validator->errors()], 422);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json(['success'=>true,'user'=>$user,'token' => $token]);
        }

        return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
    }

    public function destroy(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        return response()->json(['success' => true]);
    }

}
