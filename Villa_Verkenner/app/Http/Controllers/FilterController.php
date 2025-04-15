<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Feature;
use App\Models\GeoOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FilterController extends Controller
{
    public function filterHouses(Request $request)
    {
        // Get all features and geo options for the filter dropdowns
        $allFeatures = Feature::all();
        $allGeoOptions = GeoOption::all();

        $query = House::withoutTrashed();

        // Apply search filter if provided
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%")
                  ->orWhere('address', 'like', "%$search%");
            });
        }

        // Apply price range filter
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Apply features filter
        if ($request->has('features') && !empty($request->features)) {
            $featureIds = is_array($request->features) ? $request->features : [$request->features];
            
            $query->whereHas('features', function ($q) use ($featureIds) {
                $q->whereIn('feature.id', $featureIds);
            }, '=', count($featureIds));
        }

        // Apply geo options filter
        if ($request->has('geoOptions') && !empty($request->geoOptions)) {
            $geoOptionIds = is_array($request->geoOptions) ? $request->geoOptions : [$request->geoOptions];
            
            $query->whereHas('geoOptions', function ($q) use ($geoOptionIds) {
                $q->whereIn('geo_option.id', $geoOptionIds);
            }, '=', count($geoOptionIds));
        }

        $houses = $query->with(['features', 'geoOptions'])->get();

        if ($request->ajax()) {
            $html = view('partials.houses', compact('houses'))->render();
            return response()->json(['html' => $html]);
        }

        return view('pages.aanbod', compact('houses', 'allFeatures', 'allGeoOptions'));
    }
}