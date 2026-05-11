<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * MapController
 * 
 * Handles map display and filtering
 */
class MapController extends Controller
{
    /**
     * Display the interactive map
     */
    public function index(Request $request)
    {
        $query = Location::where('user_id', Auth::id())
            ->with('category');

        // Filter by category
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Search by location name
        if ($request->has('search') && $request->search) {
            $query->where('location_name', 'like', '%' . $request->search . '%');
        }

        $locations = $query->get();
        $categories = Category::all();

        return view('map.index', [
            'locations' => $locations,
            'categories' => $categories,
            'selectedCategory' => $request->category_id,
            'searchTerm' => $request->search,
        ]);
    }

    /**
     * Get locations as GeoJSON for map display
     */
    public function getGeoJson(Request $request)
    {
        $query = Location::where('user_id', Auth::id())
            ->with('category');

        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('search') && $request->search) {
            $query->where('location_name', 'like', '%' . $request->search . '%');
        }

        $locations = $query->get();

        // Convert to GeoJSON format
        $features = $locations->map(function ($location) {
            return [
                'type' => 'Feature',
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [$location->longitude, $location->latitude],
                ],
                'properties' => [
                    'id' => $location->id,
                    'name' => $location->location_name,
                    'description' => $location->description,
                    'category' => $location->category->category_name ?? 'Other',
                    'image' => $location->getImageUrl(),
                    'url' => route('locations.show', $location),
                ],
            ];
        });

        return response()->json([
            'type' => 'FeatureCollection',
            'features' => $features,
        ]);
    }
}
