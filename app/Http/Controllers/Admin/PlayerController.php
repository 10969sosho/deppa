<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Services\PlayerService;
use App\Support\Logo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PlayerController extends Controller
{
    public function __construct(
        private readonly PlayerService $playerService
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only([
            'search', 'jenjang', 'gender', 'is_finish',
            'date_from', 'date_to', 'sort_field', 'sort_order', 'per_page',
        ]);

        $players = $this->playerService->paginate($filters);
        $jenjangList = $this->playerService->getJenjangList();

        return view('admin.players.index', compact('players', 'jenjangList', 'filters'));
    }

    public function show(int $id): View
    {
        $player = $this->playerService->findById($id);

        return view('admin.players.show', compact('player'));
    }

    public function testReport(int $id)
    {
        $player = Player::findOrFail($id);

        $pdf = Pdf::loadView('api.exports.report', compact('player'));

        return $pdf->stream('laporan-game-'.Str::slug($player->nama).'.pdf');
    }

    public function testCertificate(int $id)
    {
        $player = Player::findOrFail($id);

        if (! $player->is_finish) {
            abort(404, 'Player belum menyelesaikan game.');
        }

        $logo = Logo::dataUri();
        $pdf = Pdf::loadView('api.exports.certificate', compact('player', 'logo'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('sertifikat-'.Str::slug($player->nama).'.pdf');
    }
}
