<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\HouseImage;
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
            'username' => 'Gebruikersnaam of wachtwoord is onjuist.',
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
            'description' => 'required|max:5000',
            'price' => 'required|numeric|min:25000|max:2000000',
            'address' => 'required|max:255',
            'rooms' => 'required|integer|min:1|max:20',
            'status' => 'required',
            'popular' => 'required|boolean',
            'images' => 'required|array|min:1|max:5',
            'images.*' => 'image|max:10240',
            'features' => 'required|array|min:1',
            'geo_options' => 'required|array|min:1',
        ]);

        $validated['popular'] = $request->has('popular') ? true : false;

        $validated['image'] = 'houses/defaultImage.webp';

        $house = House::create($validated);

        // Process images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imagePath = $image->store('houses', 'public');

                $house->images()->create([
                    'image_path' => $imagePath,
                    'is_primary' => $index === 0,
                    'display_order' => $index,
                ]);

                if ($index === 0) {
                    $house->update(['image' => $imagePath]);
                }
            }
        }

        // Sync relationships
        if ($request->has('features')) {
            $house->features()->sync($request->features);
        }

        if ($request->has('geo_options')) {
            $house->geoOptions()->sync($request->geo_options);
        }

        return redirect()->route('admin.dashboard')
            ->with('success', 'Woning succesvol aangemaakt!');
    }

    public function updateHouse(Request $request, House $house)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:5000',
            'price' => 'required|numeric|min:25000|max:2000000',
            'address' => 'required|max:255',
            'rooms' => 'required|integer|min:1|max:20',
            'status' => 'required',
            'popular' => 'required|boolean',
            'new_images' => 'nullable|array|max:5',
            'new_images.*' => 'image|max:10240',
            'delete_image_ids' => 'nullable|array',
            'primary_image_id' => 'nullable|integer',
            'features' => 'required|array|min:1',
            'geo_options' => 'required|array|min:1',
        ]);

        // Fix for select dropdown - convert "0"/"1" to boolean
        $validated['popular'] = ($request->input('popular') == '1');

        // Log for debugging
        Log::info('Updating house popular status', [
            'house_id' => $house->id,
            'original_popular' => $house->popular,
            'new_popular' => $validated['popular'],
            'request_value' => $request->input('popular')
        ]);

        $house->update($validated);

        if ($request->has('delete_image_ids') && count($request->delete_image_ids) > 0) {
            $imagesToDelete = $house->images()->whereIn('id', $request->delete_image_ids)->get();

            $remainingImagesCount = $house->images()->count() - count($request->delete_image_ids);

            if ($remainingImagesCount > 0 || $request->hasFile('new_images')) {
                foreach ($imagesToDelete as $image) {
                    if (Storage::disk('public')->exists($image->image_path)) {
                        Storage::disk('public')->delete($image->image_path);
                    }
                    $image->delete();
                }
            } else {
                return redirect()->back()->withErrors(['delete_image_ids' => 'Er moet minstens één afbeelding zijn voor de woning.']);
            }
        }

        // Handle new image uploads
        if ($request->hasFile('new_images')) {
            $currentImageCount = $house->images()->count();
            $newImagesCount = count($request->file('new_images'));

            if ($currentImageCount + $newImagesCount > 5) {
                return redirect()->back()->withErrors(['new_images' => 'Maximaal 5 afbeeldingen toegestaan.']);
            }

            $startOrder = $currentImageCount;
            foreach ($request->file('new_images') as $index => $image) {
                $imagePath = $image->store('houses', 'public');

                $house->images()->create([
                    'image_path' => $imagePath,
                    'is_primary' => false,
                    'display_order' => $startOrder + $index,
                ]);
            }
        }

        if ($request->has('primary_image_id') && $request->primary_image_id) {
            $house->images()->update(['is_primary' => false]);
            $primaryImage = $house->images()->findOrFail($request->primary_image_id);
            $primaryImage->update(['is_primary' => true]);

            $house->update(['image' => $primaryImage->image_path]);
        } elseif ($house->images()->where('is_primary', true)->count() === 0 && $house->images()->count() > 0) {
            $firstImage = $house->images()->orderBy('display_order')->first();
            $firstImage->update(['is_primary' => true]);
            $house->update(['image' => $firstImage->image_path]);
        }

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
            ->with('success', 'Woning succesvol bijgewerkt!');
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
            ->with('success', 'Woning succesvol verwijderd uit de lijsten!');
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
            ->with('success', 'Woning is succesvol hersteld.');
    }

    public function reorderImages(Request $request, House $house)
    {
        $request->validate([
            'image_order' => 'required|array',
            'image_order.*' => 'integer|exists:house_images,id'
        ]);

        foreach ($request->image_order as $order => $imageId) {
            $house->images()->where('id', $imageId)->update(['display_order' => $order]);
        }

        return response()->json(['success' => true]);
    }

    public function deleteImage(Request $request, $imageId)
    {
        $image = HouseImage::findOrFail($imageId);
        $house = $image->house;

        if ($house->images()->count() <= 1) {
            return response()->json([
                'success' => false,
                'message' => 'Er moet minstens één afbeelding zijn voor de woning.'
            ], 422);
        }

        if ($image->is_primary) {
            $newPrimary = $house->images()->where('id', '!=', $image->id)->first();
            $newPrimary->update(['is_primary' => true]);
            $house->update(['image' => $newPrimary->image_path]);
        }

        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        return response()->json(['success' => true]);
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
            ->with('success', 'Eigenschap succesvol aangemaakt');
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
            ->with('success', 'Eigenschap succesvol bijgewerkt');
    }

    public function featureDestroy(Feature $feature)
    {
        if ($feature->houses()->count() > 0) {
            return redirect()->route('admin.features.index')
                ->with('error', 'Deze eigenschap kan niet worden verwijderd omdat het in gebruik is bij één of meerdere woningen');
        }

        $feature->delete();

        return redirect()->route('admin.features.index')
            ->with('success', 'Eigenschap succesvol verwijderd');
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
            ->with('success', 'Locatie optie succesvol aangemaakt');
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
            ->with('success', 'Locatie optie succesvol bijgewerkt');
    }

    public function geoOptionDestroy(GeoOption $geoOption)
    {
        if ($geoOption->houses()->count() > 0) {
            return redirect()->route('admin.geo-options.index')
                ->with('error', 'Deze locatie optie kan niet worden verwijderd omdat het in gebruik is bij één of meerdere woningen');
        }

        $geoOption->delete();

        return redirect()->route('admin.geo-options.index')
            ->with('success', 'Locatie optie succesvol verwijderd');
    }
}
