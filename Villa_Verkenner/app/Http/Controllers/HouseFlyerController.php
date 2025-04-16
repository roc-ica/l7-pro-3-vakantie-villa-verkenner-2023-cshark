<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;

class HouseFlyerController extends Controller
{
    public function generate(House $house)
    {
        // Load house with relationships
        $house->load('images', 'features', 'geoOptions');

        // Get the domain for creating absolute URLs
        $baseUrl = request()->getSchemeAndHttpHost();

        // Return as HTML view (not downloadable)
        return view('flyer.house', [
            'house' => $house,
            'baseUrl' => $baseUrl
        ]);
    }
}
