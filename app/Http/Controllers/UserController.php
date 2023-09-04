<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('authority', 0)->get();
        $applicants = User::where('authority', null)->get();

        return response()->json([
            'users' => $users,
            'applicants' => $applicants
        ]);
    }

    public function approval(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'affiliation' => 'required|string'
        ]);

        User::where('name', $request->input('name'))
            ->where('affiliation', $request->input('affiliation'))
            ->update(['authority' => 0]);

        return response()->json('User approved successfully', 201);
    }
}
