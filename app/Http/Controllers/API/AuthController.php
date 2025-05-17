<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{




    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);

        try {
            $user = User::create($data);
        } catch (QueryException $e) {
            // Em MySQL, erro 1062 = Duplicate entry (SQLSTATE 23000)
             
            if (

                $e->getCode() === '23000'
                || (isset($e->errorInfo[1]) && $e->errorInfo[1] === 1062)
            ) {
                return response()->json([
                    'message' => 'Usuário já cadastrado com este e-mail.'
                ], 409);
            }
            // Se for outro erro de query, relança
            throw $e;
        }

        // Gera token de API
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'user'  => $user,
            'token' => $token,
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        // Busca usuário
        $user = \App\Models\User::where('email', $credentials['email'])->first();

        // Verifica senha
        if (! Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'Credenciais inválidas.'
            ], 401);
        }

        // Gera novo token
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'user'  => $user,
            'token' => $token,
        ], 200);
    }
}
