<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OostenrijkController extends Controller
{
    protected $popularHousesController;

    public function __construct(PopularHousesController $popularHousesController)
    {
        $this->popularHousesController = $popularHousesController;
    }

    public function index()
    {
        // Get popular houses using the dedicated controller
        $popularHouses = $this->popularHousesController->getPopularHouses(3);
        
        return view('pages.over-oostenrijk', [
            'popularHouses' => $popularHouses
        ]);
    }
}
