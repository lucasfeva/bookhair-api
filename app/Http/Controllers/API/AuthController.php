<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Auth;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{

    /**
     * Registra um novo usuário e retorna token de acesso.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        // Validação realizada em RegisterRequest
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $data['name'] = $data['nome'];
        unset($data['nome']); // <-- ESSA LINHA REMOVE O CAMPO 'nome'

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

        // Cria token via Sanctum
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'user'  => $user,
            'token' => $token,
        ], 201);
    }

    /**
     * Autentica usuário e retorna token.
     */
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

    /**
     * Revoga todos os tokens do usuário logado.
     */
    public function logout(): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Revoga todos os tokens ativos
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Logout realizado com sucesso.'
        ], 200);
    }

    /**
     * Gera novo token invalidando o anterior.
     */
    public function refreshToken(): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Opcional: deletar token atual ou todos
        $user->currentAccessToken()->delete();

        $newToken = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'token' => $newToken,
        ], 200);
    }
}
