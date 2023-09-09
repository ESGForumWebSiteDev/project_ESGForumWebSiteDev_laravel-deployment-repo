<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
    public function count()
    {
        $members = Member::where('authority', '<>', env('REJECTED_MEMBER'))->count();
        $applicants = Member::where('authority', null)->count();

        return response()->json([
            'members' => $members,
            'applicants' => $applicants
        ]);
    }

    public function index()
    {
        $members = Member::where('authority', '<>', env('REJECTED_MEMBER'))->get();

        return response()->json($members);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'affiliation' => 'required|string'
        ]);

        $isMember = Member::where('name', $request->input('name'))
            ->where('affiliation', $request->input('affiliation'))
            ->where('authority', '<>', env('REJECTED_MEMBER'))
            ->get();

        if ($isMember) {
            return response()->json('conflict with existing members', 409);
        }

        $member = Member::create([
            'name' => $request->input('name'),
            'affiliation' => $request->input('affiliation'),
        ]);

        return response()->json($member, 201);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|integer',
        ]);

        Member::whereIn('id', $request->input('ids'))->delete();
        return response()->json(['message' => 'Member deleted successfully'], 204);
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

    public function approval(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|integer',
        ]);

        Member::whereIn('id', $request->input('ids'))
            ->update(['authority' => 0]);

        return response()->json('Member approved successfully', 201);
    }
    public function rejection(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|integer',
        ]);

        Member::whereIn('id', $request->input('ids'))
            ->update(['authority' => env('REJECTED_MEMBER')]);

        return response()->json('Member rejected successfully', 201);
    }

    public function applicants()
    {
        $applicants = Member::where('authority', null)->get();

        return response()->json($applicants);
    }
}
