<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FinishGameRequest;
use App\Http\Requests\StorePlayerRequest;
use App\Models\Player;
use App\Models\User;
use App\Services\PlayerService;
use App\Support\Logo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PlayerController extends Controller
{
    public function __construct(
        private readonly PlayerService $playerService
    ) {}

    public function store(StorePlayerRequest $request): JsonResponse
    {
        $data = $request->validated();

        $player = DB::transaction(function () use ($data): Player {
            $user = User::create(['name' => $data['nama']]);

            return $this->playerService->register([
                ...$data,
                'user_id' => $user->id,
            ]);
        });

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
        ], 201);
    }

    public function findByName(string $name): JsonResponse
    {
        $player = Player::whereRaw('LOWER(nama) = LOWER(?)', [$name])->first();

        if (! $player) {
            return response()->json([
                'success' => false,
                'message' => 'Player tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $player->id,
                'nama' => $player->nama,
                'usia' => $player->usia,
                'jenjang' => $player->jenjang,
                'gender' => $player->gender,
                'score' => $player->score,
                'duration' => $player->duration,
                'is_finish' => $player->is_finish,
            ],
        ]);
    }

    public function finish(string $name, FinishGameRequest $request): JsonResponse
    {
        $player = $this->ownedPlayer($name, $request);

        $this->playerService->finishGame($player->id, $request->validated());

        return response()->json([
            'success' => true,
        ]);
    }

    public function report(string $name, Request $request): Response
    {
        $player = $this->ownedPlayer($name, $request);

        if (! $player->is_finish) {
            abort(404);
        }

        $pdf = Pdf::loadView('api.exports.report', compact('player'));

        return $pdf->download('laporan-game-'.Str::slug($player->nama).'.pdf');
    }

    public function certificate(string $name, Request $request): Response
    {
        $player = $this->ownedPlayer($name, $request);

        if (! $player->is_finish) {
            abort(404);
        }

        $logo = Logo::dataUri();
        $pdf = Pdf::loadView('api.exports.certificate', compact('player', 'logo'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('sertifikat-'.Str::slug($player->nama).'.pdf');
    }

    private function ownedPlayer(string $name, Request $request): Player
    {
        return Player::where('user_id', $request->user()->id)
            ->whereRaw('LOWER(nama) = LOWER(?)', [$name])
            ->firstOrFail();
    }
}
