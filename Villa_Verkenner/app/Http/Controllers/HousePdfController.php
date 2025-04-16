<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class HousePdfController extends Controller
{
    public function generate(House $house)
    {
        $house->load('images', 'features', 'geoOptions');

        try {
            $domain = request()->getSchemeAndHttpHost();

            $house->primary_image_url = $domain . '/storage/' . $house->primary_image;

            $limitedImages = $house->images->where('is_primary', false)->take(4);
            $imageUrls = [];

            foreach ($limitedImages as $image) {
                $imageUrls[] = [
                    'url' => $domain . '/storage/' . $image->image_path,
                    'alt' => $house->name
                ];
            }

            $house->image_urls = $imageUrls;

            $pdf = PDF::setOptions([
                'defaultFont' => 'sans-serif',
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'enable_php' => true,
            ])->loadView('pdf.house', compact('house'));

            $pdf->setPaper('a4', 'portrait');

            return $pdf->download($house->name . '.pdf');
        } catch (\Exception $e) {
            \Log::error('PDF Generation Error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());

            return back()->with('error', 'Er is een probleem opgetreden bij het genereren van de PDF. ' . $e->getMessage());
        }
    }
}
