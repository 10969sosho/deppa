<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Game - {{ $player->nama }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; color: #333; padding: 30px; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #0d6efd; padding-bottom: 15px; }
        .header h1 { margin: 0; color: #0d6efd; font-size: 22px; }
        .header p { margin: 5px 0 0; color: #666; font-size: 12px; }
        .info { margin-bottom: 20px; }
        .info table { width: 100%; border-collapse: collapse; }
        .info td { padding: 8px 12px; border-bottom: 1px solid #eee; }
        .info td:first-child { font-weight: bold; width: 150px; color: #555; }
        .score-box { text-align: center; margin: 25px 0; }
        .score-value { font-size: 48px; font-weight: bold; color: #198754; }
        .score-label { font-size: 14px; color: #666; margin-top: 5px; }
        .footer { margin-top: 30px; text-align: center; font-size: 11px; color: #999; border-top: 1px solid #eee; padding-top: 15px; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 12px; }
        .badge-success { background: #d1e7dd; color: #0f5132; }
        .badge-secondary { background: #e2e3e5; color: #41464b; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Hasil Game</h1>
        <p>Si Doel Smart Finance — {{ $player->nama }}</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td>Nama</td>
                <td>{{ $player->nama }}</td>
            </tr>
            <tr>
                <td>Usia</td>
                <td>{{ $player->usia }} tahun</td>
            </tr>
            <tr>
                <td>Jenjang Pendidikan</td>
                <td>{{ $player->jenjang }}</td>
            </tr>
            <tr>
                <td>Gender</td>
                <td>{{ $player->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td>Tanggal Bermain</td>
                <td>{{ $player->created_at->format('d F Y H:i') }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                    @if($player->is_finish)
                        <span class="badge badge-success">Selesai</span>
                    @else
                        <span class="badge badge-secondary">Belum Selesai</span>
                    @endif
                </td>
            </tr>
            @if($player->is_finish)
            <tr>
                <td>Durasi Bermain</td>
                <td>{{ number_format($player->duration, 1) }} menit</td>
            </tr>
            <tr>
                <td>Tanggal Selesai</td>
                <td>{{ $player->updated_at->format('d F Y H:i') }}</td>
            </tr>
            @endif
        </table>
    </div>

    @if($player->is_finish)
    <div class="score-box">
        <div class="score-value">{{ number_format($player->score) }}</div>
        <div class="score-label">Skor Akhir</div>
    </div>
    @endif

    <div class="footer">
        Laporan ini dibuat otomatis oleh Si Doel Smart Finance &mdash; {{ now()->format('d F Y H:i') }}
    </div>
</body>
</html>
