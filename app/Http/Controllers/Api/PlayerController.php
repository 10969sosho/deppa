<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlayerRequest;
use App\Models\Player;
use Illuminate\Http\JsonResponse;

class PlayerController extends Controller
{
    /**
     * Store a newly created player in storage.
     */
    public function store(StorePlayerRequest $request): JsonResponse
    {
        $player = Player::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Player berhasil disimpan',
            'data' => $player,
        ], 201);
    }
}
