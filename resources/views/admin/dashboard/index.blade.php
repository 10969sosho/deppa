@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-controller me-2"></i>Si Doel Smart Finance</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.export.excel') }}" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel"></i> Excel</a>
        <a href="{{ route('admin.export.pdf') }}" class="btn btn-danger btn-sm"><i class="bi bi-file-earmark-pdf"></i> PDF</a>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-start border-primary border-4">
            <div class="card-body py-3">
                <p class="text-muted mb-0 small">Total Player</p>
                <h3 class="mb-0">{{ number_format($stats['total_players']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-start border-success border-4">
            <div class="card-body py-3">
                <p class="text-muted mb-0 small">Game Selesai</p>
                <h3 class="mb-0">{{ number_format($stats['total_finished']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-start border-warning border-4">
            <div class="card-body py-3">
                <p class="text-muted mb-0 small">Rata-rata Nilai</p>
                <h3 class="mb-0">{{ $stats['avg_score'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-start border-info border-4">
            <div class="card-body py-3">
                <p class="text-muted mb-0 small">Rata-rata Durasi</p>
                <h3 class="mb-0">{{ number_format($stats['avg_duration']) }} dtk</h3>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-table me-1"></i> Data Player</span>
        <div>
            <a href="{{ route('admin.players.index') }}" class="btn btn-outline-primary btn-sm">Lihat Semua</a>
        </div>
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
                            <td>{{ $p->is_finish ? $p->duration . ' dtk' : '-' }}</td>
                            <td>
                                @if($p->is_finish)
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-secondary">Belum</span>
                                @endif
                            </td>
                            <td class="small">{{ $p->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center py-4 text-muted">Belum ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
