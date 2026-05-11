<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

/**
 * HomeController
 * 
 * Handles home and about pages
 */
class HomeController extends Controller
{
    /**
     * Show the home page
     */
    public function index(): View
    {
        return view('home');
    }

    /**
     * Show the about page
     */
    public function about(): View
    {
        return view('about');
    }
}
