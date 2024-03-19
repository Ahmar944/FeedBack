<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Method to get user data
    public function getUserData(Request $request)
    {
        $user = $request->user(); 
        return response()->json(['success' => true, 'data' => $user]);
    }

    // Other user-related methods can be defined here
}