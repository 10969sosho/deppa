<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Sertifikat — Si Doel Smart Finance</title>
    <style>
        @page { size: 297mm 210mm; margin: 0; }
        body {
            font-family: Arial, sans-serif;
            margin: 0; padding: 0;
            width: 297mm; height: 210mm;
            background: #fff;
        }
        .page-table {
            width: 297mm; height: 210mm;
            border-collapse: collapse;
            margin: 0; padding: 0;
        }
        .cert {
            width: 273mm; height: 186mm;
            border: 6px solid #0d6efd;
            border-radius: 12px;
            text-align: center;
            padding: 12mm 14mm;
            box-sizing: border-box;
        }
        .cert-inner {
            width: 100%; height: 100%;
            border: 2px solid #e0e7ff;
            border-radius: 8px;
            box-sizing: border-box;
            padding-top: 6mm;
        }
        .logo img { width: 24mm; height: 24mm; }
        .title { font-size: 34px; font-weight: bold; color: #0d6efd; text-transform: uppercase; letter-spacing: 3px; margin-top: 2mm; }
        .subtitle { font-size: 16px; color: #666; margin-top: 1mm; }
        .to-label { font-size: 14px; color: #888; margin-top: 5mm; }
        .recipient { font-size: 30px; font-weight: bold; color: #212529; margin-top: 2mm; }
        .description { font-size: 14px; color: #555; margin-top: 4mm; line-height: 1.7; }
        .score { font-size: 36px; font-weight: bold; color: #198754; margin-top: 4mm; }
        .details { font-size: 12px; color: #777; margin-top: 3mm; }
        .details span { margin: 0 12px; }
        .sig-line { width: 55mm; border-top: 1px solid #333; margin: 8mm auto 2mm; }
        .signature { font-size: 12px; color: #555; }
        .signature-date { font-size: 10px; color: #999; }
    </style>
</head>
<body>
    <table class="page-table">
        <tr>
            <td style="text-align:center; vertical-align:middle;">
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
            </td>
        </tr>
    </table>
</body>
</html>
