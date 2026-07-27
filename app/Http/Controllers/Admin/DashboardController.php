<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Services\PlayerService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private readonly PlayerService $playerService
    ) {}

    public function index(): View
    {
        $stats = $this->playerService->getStats();

        $recentPlayers = Player::query()
            ->select(['id', 'nama', 'jenjang', 'gender', 'score', 'duration', 'is_finish', 'created_at'])
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return view('admin.dashboard.index', compact('stats', 'recentPlayers'));
    }
}
