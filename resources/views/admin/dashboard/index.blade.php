@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-controller me-2"></i>Si Doel Smart Finance</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.export.excel') }}" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel"></i> Excel</a>
        <a href="{{ route('admin.export.pdf') }}" class="btn btn-danger btn-sm" target="_blank"><i class="bi bi-file-earmark-pdf"></i> PDF</a>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card primary h-100">
            <div class="card-body py-3">
                <p class="text-muted mb-0 small"><i class="bi bi-people me-1"></i> Total Player</p>
                <h3 class="mb-0">{{ number_format($stats['total_players']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card success h-100">
            <div class="card-body py-3">
                <p class="text-muted mb-0 small"><i class="bi bi-check2-circle me-1"></i> Game Selesai</p>
                <h3 class="mb-0">{{ number_format($stats['total_finished']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card warning h-100">
            <div class="card-body py-3">
                <p class="text-muted mb-0 small"><i class="bi bi-bar-chart me-1"></i> Rata-rata Nilai</p>
                <h3 class="mb-0">{{ $stats['avg_score'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card info h-100">
            <div class="card-body py-3">
                <p class="text-muted mb-0 small"><i class="bi bi-clock me-1"></i> Rata-rata Durasi</p>
                <h3 class="mb-0">{{ number_format($stats['avg_duration']) }} mnt</h3>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span><i class="bi bi-table me-1"></i> Data Player Terbaru</span>
        <a href="{{ route('admin.players.index') }}" class="btn btn-outline-primary btn-sm">Lihat Semua</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Jenjang</th>
                        <th>Gender</th>
                        <th>Score</th>
                        <th>Durasi</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentPlayers as $p)
                        <tr>
                            <td class="text-muted small">{{ $p->id }}</td>
                            <td>{{ $p->nama }}</td>
                            <td>{{ $p->jenjang }}</td>
                            <td>{{ $p->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            <td>{{ $p->is_finish ? $p->score : '-' }}</td>
                            <td>{{ $p->is_finish ? ($p->duration >= 60 ? round($p->duration / 60, 1) : $p->duration) . ' mnt' : '-' }}</td>
                            <td>
                                @if($p->is_finish)
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-secondary">Belum</span>
                                @endif
                            </td>
                            <td class="small">{{ $p->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.players.destroy', $p->id) }}" onsubmit="return confirm('Hapus data player \"{{ addslashes($p->nama) }}\"?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center py-4 text-muted">Belum ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection