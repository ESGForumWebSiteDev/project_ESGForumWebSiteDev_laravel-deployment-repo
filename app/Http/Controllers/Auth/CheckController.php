<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckController extends Controller
{
    public function isLoggedIn(Request $request)
    {
        return response()->json(['success' => true], 200);
    }
}
