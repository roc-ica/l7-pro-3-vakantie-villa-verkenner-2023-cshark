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
}
