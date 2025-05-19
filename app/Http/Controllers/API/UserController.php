<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Retorna perfil do usuário autenticado
    public function getProfile(): JsonResponse
    {
        return response()->json(Auth::user());
    }

    // Atualiza dados do perfil
    public function updateProfile(UpdateUserRequest $request): JsonResponse
    {
        $user = Auth::user();
        $user->update($request->validated());

        return response()->json([
            'message' => 'Perfil atualizado com sucesso',
            'user'    => $user,
        ]);
    }
}
