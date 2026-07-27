<?php

namespace App\Exports;

use App\Models\Player;
use OpenSpout\Writer\XLSX\Writer;
use OpenSpout\Common\Entity\Row;
use Illuminate\Database\Eloquent\Collection;

class PlayerExport
{
    public function excel(): string
    {
        $path = storage_path('app/player-export.xlsx');
        $writer = new Writer();
        $writer->openToFile($path);

        $writer->addRow(Row::fromValues([
            'ID', 'Nama', 'Usia', 'Jenjang', 'Gender',
            'Score', 'Durasi (detik)', 'Status', 'Tanggal Daftar',
        ]));

        foreach ($this->getData() as $p) {
            $writer->addRow(Row::fromValues([
                $p->id,
                $p->nama,
                $p->usia,
                $p->jenjang,
                $p->gender === 'L' ? 'Laki-laki' : 'Perempuan',
                $p->is_finish ? $p->score : '-',
                $p->is_finish ? $p->duration : '-',
                $p->is_finish ? 'Selesai' : 'Belum',
                $p->created_at->format('d/m/Y H:i'),
            ]));
        }

        $writer->close();
        return $path;
    }

    public function pdf(): \Barryvdh\DomPDF\PDF
    {
        $players = $this->getData();
        return app('dompdf.wrapper')->loadView('admin.exports.pdf', compact('players'));
    }

    private function getData(): Collection|array
    {
        return Player::query()
            ->select(['id', 'nama', 'usia', 'jenjang', 'gender', 'score', 'duration', 'is_finish', 'created_at'])
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
