<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
    public function count()
    {
        $members = Member::all()->count();
        $applicants = Member::where('authority', null)->count();

        return response()->json([
            'members' => $members,
            'applicants' => $applicants
        ]);
    }

    public function index()
    {
        $members = Member::all();

        return response()->json($members);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'affiliation' => 'required|string'
        ]);

        $member = Member::create([
            'name' => $request->input('name'),
            'affiliation' => $request->input('affiliation'),
        ]);

        return response()->json($member, 201);
    }

    public function destroy($id)
    {
        Member::where('id', $id)->delete();

        return response()->json(['message' => 'Committee deleted successfully'], 204);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'note' => 'required|string'
        ]);

        Member::find($request->input('id'))->update(['note' => $request->input('note')]);

        $newMembersInfo = Member::all();

        return response()->json($newMembersInfo, 201);
    }

    /**
     * Check if the user is admin
     * @return \Illuminate\Http\JsonResponse
     */
    public function isAdmin()
    {
        $user = auth()->user();

        if ($user && $user->isAdmin()) {
            return response()->json([
                'is_admin' => true,
            ]);
        } else {
            return response()->json([
                'is_admin' => false,
            ]);
        }
    }

    public function approval(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        Member::find($request->input('id'))
            ->update(['authority' => 0]);

        return response()->json('User approved successfully', 201);
    }

    public function applicants()
    {
        $applicants = Member::where('authority', null)->get();

        return response()->json($applicants);
    }
}