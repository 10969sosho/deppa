<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Player</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f3f4f6; text-align: left; }
        th, td { padding: 4px 6px; border: 1px solid #d1d5db; }
        h2 { margin-bottom: 8px; }
    </style>
</head>
<body>
    <h2>Data Player - Si Doel Smart Finance</h2>
    <p>{{ now()->format('d/m/Y H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Usia</th>
                <th>Jenjang</th>
                <th>Gender</th>
                <th>Score</th>
                <th>Durasi</th>
                <th>Status</th>
                <th>Tgl Daftar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($players as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->nama }}</td>
                    <td>{{ $p->usia }}</td>
                    <td>{{ $p->jenjang }}</td>
                    <td>{{ $p->gender === 'L' ? 'L' : 'P' }}</td>
                    <td>{{ $p->is_finish ? $p->score : '-' }}</td>
                    <td>{{ $p->is_finish ? $p->duration . ' dtk' : '-' }}</td>
                    <td>{{ $p->is_finish ? 'Selesai' : 'Belum' }}</td>
                    <td>{{ $p->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
