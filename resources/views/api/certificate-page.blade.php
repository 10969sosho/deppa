<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Sertifikat — {{ $player->nama }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .card {
            background: #fff;
            border-radius: 20px;
            padding: 40px 30px;
            max-width: 400px;
            width: 100%;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #198754, #20c997);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }
        .icon svg { width: 40px; height: 40px; fill: #fff; }
        h1 {
            font-size: 22px;
            color: #212529;
            margin-bottom: 8px;
        }
        .subtitle {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 24px;
        }
        .info {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 24px;
            text-align: left;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .info-row:last-child { border-bottom: none; }
        .info-label { font-size: 13px; color: #6c757d; }
        .info-value { font-size: 14px; font-weight: 600; color: #212529; }
        .score {
            font-size: 36px;
            font-weight: 800;
            color: #198754;
            margin: 16px 0;
        }
        .btn-download {
            display: block;
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: transform 0.15s, box-shadow 0.15s;
        }
        .btn-download:active {
            transform: scale(0.97);
        }
        .btn-download:hover {
            box-shadow: 0 8px 25px rgba(13,110,253,0.4);
        }
        .note {
            font-size: 12px;
            color: #adb5bd;
            margin-top: 16px;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">
            <svg viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM6 20V4h5v7h7v9H6zm2-6h8v1.5H8V14zm0-3h8v1.5H8V11zm0 6h5v1.5H8V17z"/></svg>
        </div>

        <h1>Sertifikat</h1>
        <p class="subtitle">Si Doel Smart Finance</p>

        <div class="info">
            <div class="info-row">
                <span class="info-label">Nama</span>
                <span class="info-value">{{ $player->nama }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Jenjang</span>
                <span class="info-value">{{ $player->jenjang }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Durasi</span>
                <span class="info-value">{{ number_format($player->duration, 1) }} menit</span>
            </div>
        </div>

        <div class="score">{{ number_format($player->score) }}</div>

        <a href="{{ url('/api/player/' . $name . '/certificate') }}" class="btn-download" id="downloadBtn">
            Download Sertifikat
        </a>

        <p class="note">PDF akan otomatis terdownload</p>
    </div>

    <script>
        // Force download via fetch + blob (works better in WebView)
        document.getElementById('downloadBtn').addEventListener('click', function(e) {
            e.preventDefault();
            var btn = this;
            var url = this.href;

            btn.textContent = 'Downloading...';
            btn.style.opacity = '0.7';
            btn.style.pointerEvents = 'none';

            fetch(url)
                .then(function(response) {
                    if (!response.ok) throw new Error('Gagal');
                    return response.blob();
                })
                .then(function(blob) {
                    var a = document.createElement('a');
                    a.href = URL.createObjectURL(blob);
                    a.download = 'sertifikat-{{ Str::slug($player->nama) }}.pdf';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    URL.revokeObjectURL(a.href);

                    btn.textContent = 'Downloaded!';
                    btn.style.background = 'linear-gradient(135deg, #198754, #20c997)';
                    setTimeout(function() {
                        btn.textContent = 'Download Sertifikat';
                        btn.style.opacity = '1';
                        btn.style.pointerEvents = 'auto';
                        btn.style.background = '';
                    }, 2000);
                })
                .catch(function() {
                    // Fallback: direct navigation
                    window.location.href = url;
                    btn.textContent = 'Download Sertifikat';
                    btn.style.opacity = '1';
                    btn.style.pointerEvents = 'auto';
                });
        });
    </script>
</body>
</html>
