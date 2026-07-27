<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $playerPerDay = $this->playerService->getPlayerPerDay();
        $scorePerDay = $this->playerService->getScorePerDay();

        return view('admin.dashboard.index', compact(
            'stats',
            'playerPerDay',
            'scorePerDay'
        ));
    }
}
