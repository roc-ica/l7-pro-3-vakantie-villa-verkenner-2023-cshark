<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;

class AustriaController extends Controller
{
    public function index()
    {
        // Get the 3 most recent popular houses
        $popularHouses = House::where('popular', true)
                                    ->latest()
                                    ->take(3)
                                    ->get();
        
        return view('pages.over-oostenrijk', [
            'popularHouses' => $popularHouses
        ]);
    }
}