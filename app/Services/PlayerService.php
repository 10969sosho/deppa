<?php

namespace App\Services;

use App\Models\Player;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PlayerService
{
    public function register(array $data): Player
    {
        return Player::create([
            'user_id' => $data['user_id'] ?? null,
            'nama' => $data['nama'],
            'usia' => $data['usia'],
            'jenjang' => $data['jenjang'],
            'gender' => $data['gender'],
        ]);
    }

    public function finishGame(int $id, array $data): Player
    {
        $player = Player::findOrFail($id);

        $duration = round($player->created_at->diffInMinutes(now(), true), 1);
        $player->update([
            'score' => $data['score'],
            'duration' => $duration,
            'is_finish' => true,
        ]);

        return $player;
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        $query = Player::query();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('jenjang', 'like', "%{$search}%")
                    ->orWhere('gender', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['jenjang'])) {
            $query->where('jenjang', $filters['jenjang']);
        }

        if (!empty($filters['gender'])) {
            $query->where('gender', $filters['gender']);
        }

        if (!empty($filters['is_finish'])) {
            $query->where('is_finish', $filters['is_finish'] === 'yes');
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortOrder = $filters['sort_order'] ?? 'desc';
        $allowedSortFields = ['id', 'nama', 'usia', 'score', 'duration', 'created_at'];

        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortOrder === 'asc' ? 'asc' : 'desc');
        }

        $perPage = min((int) ($filters['per_page'] ?? 20), 100);

        return $query->paginate($perPage);
    }

    public function findById(int $id): Player
    {
        return Player::findOrFail($id);
    }

    public function deletePlayer(int $id): void
    {
        $player = Player::findOrFail($id);

        DB::transaction(function () use ($player) {
            if ($player->user) {
                $player->user->tokens()->delete();
                $player->user->delete();
            }

            $player->delete();
        });
    }

    public function getJenjangList(): array
    {
        return Player::select('jenjang')
            ->distinct()
            ->orderBy('jenjang')
            ->pluck('jenjang')
            ->toArray();
    }

    public function getStats(): array
    {
        return [
            'total_players' => Player::count(),
            'total_finished' => Player::where('is_finish', true)->count(),
            'avg_score' => round(Player::where('is_finish', true)->avg('score') ?? 0, 1),
            'avg_duration' => round(Player::where('is_finish', true)->avg('duration') ?? 0, 1),
        ];
    }

    public function getPlayerPerDay(int $days = 30): array
    {
        return Player::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->toArray();
    }

    public function getScorePerDay(int $days = 30): array
    {
        return Player::selectRaw('DATE(created_at) as date, AVG(score) as avg_score')
            ->where('is_finish', true)
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('avg_score', 'date')
            ->toArray();
    }
}
