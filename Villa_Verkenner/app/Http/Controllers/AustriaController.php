<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;

class AustriaController extends Controller
{
    public function index()
    {
        // Always get fresh data from database without cache
        $popularHouses = House::where('popular', true)
                            ->latest()
                            ->take(3)
                            ->get()
                            ->fresh(); // This ensures we get a fresh copy
        
        return view('pages.over-oostenrijk', [
            'popularHouses' => $popularHouses
        ]);
    }
}