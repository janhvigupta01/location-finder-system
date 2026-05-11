<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Support\Facades\Auth;

/**
 * DashboardController
 * 
 * Displays user dashboard with summary statistics
 */
class DashboardController extends Controller
{
    /**
     * Show the dashboard
     */
    public function index()
    {
        $user = Auth::user();
        $totalLocations = Location::where('user_id', $user->id)->count();
        $recentLocations = Location::where('user_id', $user->id)
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.index', [
            'totalLocations' => $totalLocations,
            'recentLocations' => $recentLocations,
        ]);
    }
}
