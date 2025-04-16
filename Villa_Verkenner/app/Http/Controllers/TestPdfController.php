<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class TestPdfController extends Controller
{
    public function test()
    {
        $data = [
            'title' => 'Test PDF',
            'content' => 'This is a test PDF to verify that the PDF generation is working correctly.'
        ];

        $pdf = PDF::loadView('pdf.test', $data);

        return $pdf->download('test.pdf');
    }
}
