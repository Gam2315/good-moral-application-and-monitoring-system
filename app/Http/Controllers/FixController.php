<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FixController extends Controller
{
    public function testModeratorProfile()
    {
        // Get the authenticated user
        $user = Auth::user();
        
        // Render the profile view without role checking
        return view('sec_osa.profile', compact('user'));
    }
}