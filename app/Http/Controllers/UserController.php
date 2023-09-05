<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;

class UserController extends Controller

{
    public function count()
    {
        $users = User::where('authority', 0)->get()->count();
        $applicants = User::where('authority', null)->get()->count();
        
        return response()->json([
            'users' => $users,
            'applicants' => $applicants
        ]);
    }

    public function index()
    {
        try {
            $users = User::where('authority', 0)->get();
            $applicants = User::where('authority', null)->get();

            return response()->json([
                'users' => $users,
                'applicants' => $applicants
            ]);
        } catch (Exception $e) {
            return response()->json('An error occurred.', $e->getCode());
        }
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
