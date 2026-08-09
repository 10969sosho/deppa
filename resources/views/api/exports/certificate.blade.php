<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Sertifikat — Si Doel Smart Finance</title>
    <style>
        @page { margin: 0; }
        body {
            font-family: Arial, sans-serif;
            margin: 0; padding: 0;
            width: 297mm; height: 210mm;
            display: flex; align-items: center; justify-content: center;
            background: #fff;
        }
        .cert {
            width: 280mm; height: 195mm;
            border: 6px solid #0d6efd;
            border-radius: 12px;
            padding: 30px 50px;
            text-align: center;
            position: relative;
            box-sizing: border-box;
        }
        .cert::before {
            content: '';
            position: absolute;
            top: 8px; left: 8px; right: 8px; bottom: 8px;
            border: 2px solid #e0e7ff;
            border-radius: 8px;
            pointer-events: none;
        }
        .logo { font-size: 28px; color: #0d6efd; margin-bottom: 8px; }
        .title { font-size: 36px; font-weight: bold; color: #0d6efd; margin: 5px 0 0; text-transform: uppercase; letter-spacing: 3px; }
        .subtitle { font-size: 16px; color: #666; margin: 5px 0 30px; }
        .recipient { font-size: 32px; font-weight: bold; color: #212529; margin: 15px 0; }
        .description { font-size: 15px; color: #555; margin: 15px 0; line-height: 1.6; }
        .score { font-size: 42px; font-weight: bold; color: #198754; margin: 15px 0; }
        .details { font-size: 13px; color: #777; margin-top: 25px; }
        .details span { margin: 0 15px; }
        .footer-sig { margin-top: 30px; font-size: 13px; color: #555; }
        .sig-line { width: 180px; border-top: 1px solid #333; margin: 30px auto 5px; }
    </style>
</head>
<body>
    <div class="cert">
        <div class="logo">&#127918;</div>
        <div class="title">Sertifikat</div>
        <div class="subtitle">Si Doel Smart Finance</div>

        <div style="font-size:15px;color:#888;">Diberikan kepada</div>
        <div class="recipient">{{ $player->nama }}</div>
        <div class="description">
            Atas keberhasilan menyelesaikan permainan<br>
            <strong>Si Doel Smart Finance</strong><br>
            dengan hasil yang memuaskan
        </div>
        <div class="score">Skor: {{ number_format($player->score) }}</div>
        <div class="details">
            <span>Jenjang: {{ $player->jenjang }}</span>
            <span>Durasi: {{ number_format($player->duration, 1) }} menit</span>
        </div>

        <div class="footer-sig">
            <div class="sig-line"></div>
            Tim Si Doel Smart Finance
            <br>
            <span style="font-size:11px;color:#999;">{{ $player->created_at->format('d F Y') }}</span>
        </div>
    </div>
</body>
</html>
