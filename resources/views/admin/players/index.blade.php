@extends('admin.layouts.app')
@section('title', 'Master Player')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-people me-2"></i>Master Player</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.export.excel') }}" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel"></i> Excel</a>
        <a href="{{ route('admin.export.pdf') }}" class="btn btn-danger btn-sm"><i class="bi bi-file-earmark-pdf"></i> PDF</a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small">Search</label>
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Nama / Jenjang / Gender" value="{{ $filters['search'] ?? '' }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small">Jenjang</label>
                <select name="jenjang" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    @foreach($jenjangList as $j)
                        <option value="{{ $j }}" {{ ($filters['jenjang'] ?? '') === $j ? 'selected' : '' }}>{{ $j }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small">Gender</label>
                <select name="gender" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    <option value="L" {{ ($filters['gender'] ?? '') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ ($filters['gender'] ?? '') === 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small">Status</label>
                <select name="is_finish" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    <option value="yes" {{ ($filters['is_finish'] ?? '') === 'yes' ? 'selected' : '' }}>Selesai</option>
                    <option value="no" {{ ($filters['is_finish'] ?? '') === 'no' ? 'selected' : '' }}>Belum</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small">Tanggal</label>
                <div class="d-flex gap-1">
                    <input type="date" name="date_from" class="form-control form-control-sm" value="{{ $filters['date_from'] ?? '' }}">
                    <input type="date" name="date_to" class="form-control form-control-sm" value="{{ $filters['date_to'] ?? '' }}">
                </div>
            </div>
            <div class="col d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-search"></i> Filter</button>
                <a href="{{ route('admin.players.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-x-circle"></i> Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Usia</th>
                        <th>Jenjang</th>
                        <th>Gender</th>
                        <th>Score</th>
                        <th>Durasi</th>
                        <th>Status</th>
                        <th>Tgl Bermain</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($players as $player)
                        <tr>
                            <td class="text-muted small">{{ $player->id }}</td>
                            <td>{{ $player->nama }}</td>
                            <td>{{ $player->usia }}</td>
                            <td>{{ $player->jenjang }}</td>
                            <td>{{ $player->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            <td>{{ $player->is_finish ? number_format($player->score) : '-' }}</td>
                            <td>{{ $player->is_finish ? ($player->duration >= 60 ? round($player->duration / 60, 1) : $player->duration) . ' mnt' : '-' }}</td>
                            <td>
                                @if($player->is_finish)
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-secondary">Belum</span>
                                @endif
                            </td>
                            <td class="small">{{ $player->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.players.show', $player) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4 text-muted">Belum ada data player</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($players->hasPages())
        <div class="card-footer">
            {{ $players->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection
