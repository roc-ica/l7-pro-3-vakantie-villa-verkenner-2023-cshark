<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;

class HouseController extends Controller
{
    public function index()
    {
        $houses = House::with(['features', 'geoOptions'])->get();
        return view('pages.aanbod', compact('houses'));
    }
}