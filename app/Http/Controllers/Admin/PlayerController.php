<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PlayerService;
use Illuminate\Http\Request;
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
}
