@extends('admin.layouts.app')
@section('title', 'Dashboard')

@push('styles')
<style>
    canvas { max-height: 300px; }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-speedometer2 me-2"></i>Dashboard</h4>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Total Player</p>
                        <h3 class="mb-0">{{ number_format($stats['total_players']) }}</h3>
                    </div>
                    <i class="bi bi-people fs-1 text-primary opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Total Game Selesai</p>
                        <h3 class="mb-0">{{ number_format($stats['total_finished']) }}</h3>
                    </div>
                    <i class="bi bi-check-circle fs-1 text-success opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Rata-rata Nilai</p>
                        <h3 class="mb-0">{{ $stats['avg_score'] }}</h3>
                    </div>
                    <i class="bi bi-star fs-1 text-warning opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Rata-rata Durasi (detik)</p>
                        <h3 class="mb-0">{{ number_format($stats['avg_duration']) }}</h3>
                    </div>
                    <i class="bi bi-clock fs-1 text-info opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-bar-chart me-1"></i> Player per Hari
            </div>
            <div class="card-body">
                <canvas id="playerChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-graph-up me-1"></i> Nilai Rata-rata per Hari
            </div>
            <div class="card-body">
                <canvas id="scoreChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const chartColors = {
    primary: '0, 110, 253',
    warning: '255, 193, 7',
};

function fillDates(data, days = 30) {
    const result = {};
    for (let i = days - 1; i >= 0; i--) {
        const d = new Date();
        d.setDate(d.getDate() - i);
        const key = d.toISOString().split('T')[0];
        result[key] = data[key] ?? 0;
    }
    return result;
}

const playerData = fillDates(@json($playerPerDay));
const scoreData = fillDates(@json($scorePerDay));

new Chart(document.getElementById('playerChart'), {
    type: 'bar',
    data: {
        labels: Object.keys(playerData),
        datasets: [{
            label: 'Player',
            data: Object.values(playerData),
            backgroundColor: 'rgba(' + chartColors.primary + ', .15)',
            borderColor: 'rgba(' + chartColors.primary + ', 1)',
            borderWidth: 1,
            borderRadius: 4,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            x: { ticks: { maxTicksLimit: 10 } },
            y: { beginAtZero: true, ticks: { stepSize: 1 } }
        }
    }
});

new Chart(document.getElementById('scoreChart'), {
    type: 'line',
    data: {
        labels: Object.keys(scoreData),
        datasets: [{
            label: 'Rata-rata Nilai',
            data: Object.values(scoreData),
            backgroundColor: 'rgba(' + chartColors.warning + ', .1)',
            borderColor: 'rgba(' + chartColors.warning + ', 1)',
            fill: true,
            tension: .3,
            pointRadius: 3,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            x: { ticks: { maxTicksLimit: 10 } },
            y: { beginAtZero: true }
        }
    }
});
</script>
@endpush
