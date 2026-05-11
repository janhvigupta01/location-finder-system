<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * LocationApiController
 * 
 * REST API for location management
 */
class LocationApiController extends Controller
{
    /**
     * Get all locations for authenticated user
     * GET /api/locations
     */
    public function index(Request $request)
    {
        $query = Location::where('user_id', Auth::id())
            ->with('category');

        // Filter by category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Search
        if ($request->has('search')) {
            $query->where('location_name', 'like', '%' . $request->search . '%');
        }

        // Pagination
        $perPage = $request->input('per_page', 10);
        $locations = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $locations->items(),
            'pagination' => [
                'total' => $locations->total(),
                'per_page' => $locations->perPage(),
                'current_page' => $locations->currentPage(),
                'last_page' => $locations->lastPage(),
            ],
        ]);
    }

    /**
     * Get single location
     * GET /api/locations/{id}
     */
    public function show($id)
    {
        $location = Location::where('user_id', Auth::id())
            ->with('category')
            ->find($id);

        if (!$location) {
            return response()->json([
                'success' => false,
                'message' => 'Location not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $location,
        ]);
    }

    /**
     * Create a new location
     * POST /api/locations
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'location_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('locations', 'public');
        }

        $validated['user_id'] = Auth::id();
        $location = Location::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Location created successfully',
            'data' => $location->load('category'),
        ], 201);
    }

    /**
     * Update a location
     * PUT /api/locations/{id}
     */
    public function update(Request $request, $id)
    {
        $location = Location::where('user_id', Auth::id())->find($id);

        if (!$location) {
            return response()->json([
                'success' => false,
                'message' => 'Location not found',
            ], 404);
        }

        $validated = $request->validate([
            'location_name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'latitude' => 'sometimes|required|numeric|between:-90,90',
            'longitude' => 'sometimes|required|numeric|between:-180,180',
            'category_id' => 'sometimes|required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($location->image) {
                Storage::disk('public')->delete($location->image);
            }
            $validated['image'] = $request->file('image')->store('locations', 'public');
        }

        $location->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Location updated successfully',
            'data' => $location->load('category'),
        ]);
    }

    /**
     * Delete a location
     * DELETE /api/locations/{id}
     */
    public function destroy($id)
    {
        $location = Location::where('user_id', Auth::id())->find($id);

        if (!$location) {
            return response()->json([
                'success' => false,
                'message' => 'Location not found',
            ], 404);
        }

        if ($location->image) {
            Storage::disk('public')->delete($location->image);
        }

        $location->delete();

        return response()->json([
            'success' => true,
            'message' => 'Location deleted successfully',
        ]);
    }

    /**
     * Get all categories
     * GET /api/categories
     */
    public function getCategories()
    {
        $categories = Category::all();

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }

    /**
     * Get locations as GeoJSON
     * GET /api/locations/geojson
     */
    public function geoJson(Request $request)
    {
        $query = Location::where('user_id', Auth::id())
            ->with('category');

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $locations = $query->get();

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
                ],
            ];
        });

        return response()->json([
            'success' => true,
            'type' => 'FeatureCollection',
            'features' => $features,
        ]);
    }
}
