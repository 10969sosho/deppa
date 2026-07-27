<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FinishGameRequest;
use App\Http\Requests\StorePlayerRequest;
use App\Services\PlayerService;
use Illuminate\Http\JsonResponse;

class PlayerController extends Controller
{
    public function __construct(
        private readonly PlayerService $playerService
    ) {}

    public function store(StorePlayerRequest $request): JsonResponse
    {
        $player = $this->playerService->register($request->validated());

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $player->id,
            ],
        ], 201);
    }

    public function finish(int $id, FinishGameRequest $request): JsonResponse
    {
        $this->playerService->finishGame($id, $request->validated());

        return response()->json([
            'success' => true,
        ]);
    }
}
