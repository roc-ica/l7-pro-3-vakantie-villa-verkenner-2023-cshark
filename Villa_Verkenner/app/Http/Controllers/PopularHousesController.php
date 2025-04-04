<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Database\Eloquent\Collection;

class PopularHousesController extends Controller
{
    /**
     * Get the most recent popular houses
     * 
     * @param int $limit The maximum number of houses to retrieve
     * @return Collection
     */
    public function getPopularHouses(int $limit = 3): Collection
    {
        return House::where('popular', true)
                    ->with(['images', 'geoOptions'])  // Eager load both images and geoOptions
                    ->orderBy('created_at', 'desc')
                    ->take($limit)
                    ->get();
    }
}
