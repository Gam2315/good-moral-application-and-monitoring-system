<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DebugController extends Controller
{
    /**
     * Display the profile page with direct HTML to bypass layout issues
     */
    public function debugProfile()
    {
        $user = Auth::user();
        
        // Log access for debugging
        Log::info('Debug Profile accessed', [
            'user_id' => $user->id,
            'account_type' => $user->account_type
        ]);
        
        return view('debug.profile', compact('user'));
    }
}