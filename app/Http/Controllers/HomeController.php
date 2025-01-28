<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home()
    {
        // Get the logged-in user
        $user = Auth::user();

        // Pass user data to the view
        return view('home', compact('user'));
    }
}
