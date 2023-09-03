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
            'email' => 'required|string',
        ]);

        User::find($request->input('email'))
            ->update(['authority' => 0]);

        return response()->json('User approved successfully', 201);
    }

    public function destroy($email)
    {
        User::find($email)->delete();

        return response()->json('User deleted successfully', 204);
    }
}
