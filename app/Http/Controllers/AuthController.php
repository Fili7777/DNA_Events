<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) { 
            // controlliamo se l'utente esiste e se la password è corretta
            return response()->json([
                'message' => 'Credenziali non valide'
            ], 401);
        }

        $token = $user->createToken('auth-token')->plainTextToken;
         // Token che il client userà nelle richieste autenticate successive

        return response()->json([
            'token' => $token,
            'user' => new \App\Http\Resources\UserResource($user),
        ]);
    }
}