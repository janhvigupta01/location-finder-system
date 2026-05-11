<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * LocationController
 * 
 * Handles CRUD operations for locations
 */
class LocationController extends Controller
{
    /**
     * Display all locations for the user
     */
    public function index()
    {
        $locations = Location::where('user_id', Auth::id())
            ->with('category')
            ->paginate(10);

        return view('locations.index', compact('locations'));
    }

    /**
     * Show location creation form
     */
    public function create()
    {
        $categories = Category::all();
        return view('locations.create', compact('categories'));
    }

    /**
     * Store a new location
     */
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'location_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('locations', 'public');
        }

        // Add user_id and create location
        $validated['user_id'] = Auth::id();
        Location::create($validated);

        return redirect()->route('locations.index')
            ->with('success', __('messages.location_added_successfully'));
    }

    /**
     * Display a single location
     */
    public function show(Location $location)
    {
        // Check if user owns the location
        if ($location->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('locations.show', compact('location'));
    }

    /**
     * Show edit form for a location
     */
    public function edit(Location $location)
    {
        // Check if user owns the location
        if ($location->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $categories = Category::all();
        return view('locations.edit', compact('location', 'categories'));
    }

    /**
     * Update a location
     */
    public function update(Request $request, Location $location)
    {
        // Check if user owns the location
        if ($location->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'location_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($location->image) {
                Storage::disk('public')->delete($location->image);
            }
            $validated['image'] = $request->file('image')->store('locations', 'public');
        }

        $location->update($validated);

        return redirect()->route('locations.show', $location)
            ->with('success', __('messages.location_updated_successfully'));
    }

    /**
     * Delete a location
     */
    public function destroy(Location $location)
    {
        // Check if user owns the location
        if ($location->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Delete image if exists
        if ($location->image) {
            Storage::disk('public')->delete($location->image);
        }

        $location->delete();

        return redirect()->route('locations.index')
            ->with('success', __('messages.location_deleted_successfully'));
    }
}
