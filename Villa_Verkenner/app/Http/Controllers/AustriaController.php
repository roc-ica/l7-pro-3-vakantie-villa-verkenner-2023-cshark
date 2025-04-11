<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;

class AustriaController extends Controller
{
    public function index()
    {
        $popularHouses = House::where('popular', true)
                            ->latest()
                            ->take(3)
                            ->get()
                            ->fresh(); 
        
        return view('pages.over-oostenrijk', [
            'popularHouses' => $popularHouses
        ]);
    }
}