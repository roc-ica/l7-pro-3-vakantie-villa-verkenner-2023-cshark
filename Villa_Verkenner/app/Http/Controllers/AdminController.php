<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Feature;
use App\Models\GeoOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\AdminMiddleware;

class AdminController extends Controller
{
    public function __construct() {}

    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('pages.admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        Log::info('Login attempt', ['username' => $request->username]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            Log::info('Login successful');
            return redirect()->intended(route('admin.dashboard'));
        }

        Log::info('Login failed');
        return back()->withErrors([
            'username' => 'Username or password is incorrect.',
        ]);
    }

    public function dashboard()
    {
        return view('pages.admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function createHouse()
    {
        $features = Feature::all();
        $geoOptions = GeoOption::all();
        return view('pages.admin.houses.create', compact('features', 'geoOptions'));
    }

    public function storeHouse(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:25000|max:2000000',
            'address' => 'required|max:255',
            'rooms' => 'required|integer|min:1|max:20',
            'status' => 'required',
            'popular' => 'required|boolean',
            'image' => 'nullable|image|max:10240',
            'features' => 'required|array|min:1', 
            'geo_options' => 'required|array|min:1', 
        ]);

        $validated['popular'] = $request->has('popular') ? true : false;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('houses', 'public');
            $validated['image'] = $imagePath;
        } else {
            $validated['image'] = 'houses/default.jpg'; // Default image
        }

        $house = House::create($validated);
        if ($request->has('features')) {
            $house->features()->sync($request->features);
        }

        if ($request->has('geo_options')) {
            $house->geoOptions()->sync($request->geo_options);
        }

        return redirect()->route('admin.dashboard')
            ->with('success', 'House created successfully!');
    }

    public function updateHouse(Request $request, House $house)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:25000|max:2000000',
            'address' => 'required|max:255',
            'rooms' => 'required|integer|min:1|max:20',
            'status' => 'required',
            'image' => 'nullable|image|max:10240',
            'popular' => 'required|boolean',
            'features' => 'required|array|min:1', 
            'geo_options' => 'required|array|min:1', 
        ]);

        $validated['popular'] = $request->has('popular');

        if ($request->hasFile('image')) {
            if ($house->image && $house->image != 'houses/default.jpg' && Storage::disk('public')->exists($house->image)) {
                Storage::disk('public')->delete($house->image);
            }

            $imagePath = $request->file('image')->store('houses', 'public');
            $validated['image'] = $imagePath;
        }

        $house->update($validated);

        if ($request->has('features')) {
            $house->features()->sync($request->features);
        } else {
            $house->features()->sync([]);
        }

        if ($request->has('geo_options')) {
            $house->geoOptions()->sync($request->geo_options);
        } else {
            $house->geoOptions()->sync([]);
        }

        return redirect()->route('admin.dashboard')
            ->with('success', 'House updated successfully!');
    }

    public function editHouse(House $house)
    {
        $features = Feature::all();
        $geoOptions = GeoOption::all();
        $selectedFeatures = $house->features->pluck('id')->toArray();
        $selectedGeoOptions = $house->geoOptions->pluck('id')->toArray();

        return view('pages.admin.houses.edit', compact(
            'house',
            'features',
            'geoOptions',
            'selectedFeatures',
            'selectedGeoOptions'
        ));
    }

    public function destroyHouse(House $house)
    {
        $house->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'House removed from listings successfully!');
    }

    public function deletedHouses()
    {
        $houses = House::onlyTrashed()->latest()->get();
        return response()->json(['houses' => $houses]);
    }

    public function restoreHouse($id)
    {
        $house = House::onlyTrashed()->findOrFail($id);
        $house->restore();

        return redirect()->route('admin.dashboard')
            ->with('success', 'House has been restored successfully.');
    }

    // Feature management methods
    public function featureIndex()
    {
        $features = Feature::latest()->paginate(10);
        return view('pages.admin.features.index', compact('features'));
    }

    public function featureCreate()
    {
        return view('pages.admin.features.create');
    }

    public function featureStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:feature,name'
        ]);

        Feature::create([
            'name' => $request->name
        ]);

        return redirect()->route('admin.features.index')
            ->with('success', 'Feature created successfully');
    }

    public function featureEdit(Feature $feature)
    {
        return view('pages.admin.features.edit', compact('feature'));
    }

    public function featureUpdate(Request $request, Feature $feature)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:feature,name,' . $feature->id
        ]);

        $feature->update([
            'name' => $request->name
        ]);

        return redirect()->route('admin.features.index')
            ->with('success', 'Feature updated successfully');
    }

    public function featureDestroy(Feature $feature)
    {
        // Check if the feature is being used by any houses
        if ($feature->houses()->count() > 0) {
            return redirect()->route('admin.features.index')
                ->with('error', 'This feature cannot be deleted because it is being used by one or more houses');
        }

        $feature->delete();

        return redirect()->route('admin.features.index')
            ->with('success', 'Feature deleted successfully');
    }

    // GeoOption management methods
    public function geoOptionIndex()
    {
        $geoOptions = GeoOption::latest()->paginate(10);
        return view('pages.admin.geo-options.index', compact('geoOptions'));
    }

    public function geoOptionCreate()
    {
        return view('pages.admin.geo-options.create');
    }

    public function geoOptionStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:geo_option,name'
        ]);

        GeoOption::create([
            'name' => $request->name
        ]);

        return redirect()->route('admin.geo-options.index')
            ->with('success', 'Location option created successfully');
    }

    public function geoOptionEdit(GeoOption $geoOption)
    {
        return view('pages.admin.geo-options.edit', compact('geoOption'));
    }

    public function geoOptionUpdate(Request $request, GeoOption $geoOption)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:geo_option,name,' . $geoOption->id
        ]);

        $geoOption->update([
            'name' => $request->name
        ]);

        return redirect()->route('admin.geo-options.index')
            ->with('success', 'Location option updated successfully');
    }

    public function geoOptionDestroy(GeoOption $geoOption)
    {
        // Check if the geo option is being used by any houses
        if ($geoOption->houses()->count() > 0) {
            return redirect()->route('admin.geo-options.index')
                ->with('error', 'This location option cannot be deleted because it is being used by one or more houses');
        }

        $geoOption->delete();

        return redirect()->route('admin.geo-options.index')
            ->with('success', 'Location option deleted successfully');
    }
}
