<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Sertifikat — Si Doel Smart Finance</title>
    <style>
        @page { size: A4 landscape; margin: 0; }
        body {
            font-family: Arial, sans-serif;
            margin: 0; padding: 0;
            width: 297mm; height: 210mm;
            background: #fff;
        }
        .cert {
            position: absolute;
            top: 7mm; left: 6mm;
            width: 285mm; height: 196mm;
            border: 6px solid #0d6efd;
            border-radius: 12px;
            text-align: center;
            box-sizing: border-box;
            padding: 10mm;
        }
        .cert-inner {
            width: 100%; height: 100%;
            border: 2px solid #e0e7ff;
            border-radius: 8px;
            box-sizing: border-box;
            padding: 5mm 8mm;
            position: relative;
        }
        .logo img { width: 20mm; height: 20mm; }
        .title { font-size: 32px; font-weight: bold; color: #0d6efd; text-transform: uppercase; letter-spacing: 3px; margin-top: 1mm; }
        .subtitle { font-size: 16px; color: #666; margin-top: 1mm; }
        .to-label { font-size: 14px; color: #888; margin-top: 3mm; }
        .recipient { font-size: 28px; font-weight: bold; color: #212529; margin-top: 2mm; }
        .description { font-size: 14px; color: #555; margin-top: 3mm; line-height: 1.7; }
        .score { font-size: 34px; font-weight: bold; color: #198754; margin-top: 3mm; }
        .details { font-size: 12px; color: #777; margin-top: 2mm; }
        .details span { margin: 0 12px; }
        .signature {
            position: absolute;
            bottom: 6mm; left: 0; right: 0;
            text-align: center;
            font-size: 12px; color: #555;
        }
        .sig-line { width: 55mm; border-top: 1px solid #333; margin: 0 auto 2mm; }
        .signature-date { font-size: 10px; color: #999; }
    </style>
</head>
<body>
    <div class="cert">
        <div class="cert-inner">
            <div class="logo">
                <img src="{{ $logo }}" alt="Logo">
            </div>
            <div class="title">Sertifikat</div>
            <div class="subtitle">Si Doel Smart Finance</div>

            <div class="to-label">Diberikan kepada</div>
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

            <div class="signature">
                <div class="sig-line"></div>
                Tim Si Doel Smart Finance<br>
                <span class="signature-date">{{ $player->created_at->format('d F Y') }}</span>
            </div>
        </div>
    </div>
</body>
</html>
