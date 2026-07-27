<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PlayerExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportController extends Controller
{
    public function excel(): BinaryFileResponse
    {
        $export = new PlayerExport();
        $path = $export->excel();

        return response()->download($path, 'data-player.xlsx')->deleteFileAfterSend();
    }

    public function pdf(): Response
    {
        $export = new PlayerExport();
        $pdf = $export->pdf();

        return $pdf->download('data-player.pdf');
    }
}
