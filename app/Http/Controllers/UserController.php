<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showUserDetails()
    {
        // Get the logged-in user
        $user = Auth::user();

        // Pass user data to the view
        return view('home', compact('user'));
    }
}
