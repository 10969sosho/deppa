<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FinishGameRequest;
use App\Http\Requests\StorePlayerRequest;
use App\Models\Player;
use App\Services\PlayerService;
use App\Support\Logo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlayerController extends Controller
{
    public function __construct(
        private readonly PlayerService $playerService
    ) {}

    public function store(StorePlayerRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $player = $this->playerService->register($data);

        return response()->json([
            'success' => true,
            'data' => ['id' => $player->id],
        ], 201);
    }

    public function finish(int $id, FinishGameRequest $request): JsonResponse
    {
        $player = Player::where('user_id', $request->user()->id)->findOrFail($id);

        $this->playerService->finishGame($player->id, $request->validated());

        return response()->json([
            'success' => true,
        ]);
    }

    public function report(int $id, Request $request): Response
    {
        $player = Player::where('user_id', $request->user()->id)->findOrFail($id);

        $pdf = Pdf::loadView('api.exports.report', compact('player'));

        return $pdf->download("laporan-game-{$player->id}.pdf");
    }

    public function certificate(int $id, Request $request): Response
    {
        $player = Player::where('user_id', $request->user()->id)->findOrFail($id);

        if (!$player->is_finish) {
            abort(404);
        }

        $logo = Logo::dataUri();
        $pdf = Pdf::loadView('api.exports.certificate', compact('player', 'logo'))
            ->setPaper('a4', 'landscape');

        return $pdf->download("sertifikat-{$player->id}.pdf");
    }
}
