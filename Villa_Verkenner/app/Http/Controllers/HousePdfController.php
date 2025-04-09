<?php

namespace App\Http\Controllers;

use App\Models\House;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class HousePdfController extends Controller
{
    /**
     *
     *
     * @param \App\Models\House $house
     * @return \Illuminate\Http\Response
     */
    public function generate(House $house)
    {
        $pdf = Pdf::loadView('pdf.house', compact('house'));

        return $pdf->download($house->name . '.pdf');
    }
}
