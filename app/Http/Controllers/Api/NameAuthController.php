<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;

class NameAuthController extends Controller
{
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $player = $request->authenticate();
        $token = $player->user->createToken('player')->plainTextToken;

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $player->id,
                'token' => $token,
                'user' => [
                    'id' => $player->user_id,
                    'name' => $player->nama,
                ],
                'player' => [
                    'id' => $player->id,
                    'name' => $player->nama,
                ],
            ],
        ]);
    }
}
