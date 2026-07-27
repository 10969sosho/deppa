@extends('admin.layouts.app')
@section('title', 'Detail Player')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-person me-2"></i>Detail Player</h4>
    <a href="{{ route('admin.players.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header"><i class="bi bi-info-circle me-1"></i> Informasi Pemain</div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr><td class="text-muted" style="width: 120px;">ID</td><td>{{ $player->id }}</td></tr>
                    <tr><td class="text-muted">Nama</td><td>{{ $player->nama }}</td></tr>
                    <tr><td class="text-muted">Usia</td><td>{{ $player->usia }} tahun</td></tr>
                    <tr><td class="text-muted">Jenjang</td><td>{{ $player->jenjang }}</td></tr>
                    <tr><td class="text-muted">Gender</td><td>{{ $player->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</td></tr>
                    <tr><td class="text-muted">Tanggal Daftar</td><td>{{ $player->created_at->format('d/m/Y H:i:s') }}</td></tr>
                    <tr><td class="text-muted">Terakhir Update</td><td>{{ $player->updated_at->format('d/m/Y H:i:s') }}</td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header"><i class="bi bi-trophy me-1"></i> Hasil Game</div>
            <div class="card-body">
                @if($player->is_finish)
                    <table class="table table-sm">
                        <tr><td class="text-muted" style="width: 120px;">Score</td><td><strong>{{ number_format($player->score) }}</strong></td></tr>
                        <tr><td class="text-muted">Durasi</td><td>{{ $player->created_at->diffInSeconds($player->updated_at) }} detik</td></tr>
                        <tr><td class="text-muted">Status</td><td><span class="badge bg-success">Selesai</span></td></tr>
                    </table>
                @else
                    <p class="text-muted mb-0">Pemain belum menyelesaikan game.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
