<?php

namespace App\Http\Controllers;

use App\Models\House;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class HousePdfController extends Controller
{
    /**
     * Generate and download a PDF for the given house.
     *
     * @param \App\Models\House $house
     * @return \Illuminate\Http\Response
     */
    public function generate(House $house)
    {
        ini_set('memory_limit', '512M');

        $house->load(['features', 'geoOptions', 'images']);

        $pdf = Pdf::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'isPhpEnabled' => true,
            'chroot' => base_path(),
            'defaultFont' => 'sans-serif',
            'dpi' => 150,
            'debugKeepTemp' => true,
            'logOutputFile' => storage_path('logs/dompdf.html'),
            'pdfBackend' => 'CPDF',
            'fontDir' => storage_path('fonts'),
        ]);

        $pdf->loadView('pdf.house', compact('house'));

        return $pdf->download($house->name . '.pdf');
    }
}
