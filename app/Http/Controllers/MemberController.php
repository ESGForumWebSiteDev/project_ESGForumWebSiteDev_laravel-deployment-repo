<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{

    public function count()
    {
        $members = Member::whereIn('authority', [-1, 0])->orWhereNull('authority')->count();
        $applicants = Member::where('authority', null)->count();

        return response()->json([
            'members' => $members,
            'applicants' => $applicants
        ]);
    }

    public function index()
    {
        $members = Member::whereIn('authority', [-1, 0])->orWhereNull('authority')->get();

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
            ->first();

        if ($isMember) {
            return response()->json('conflict with existing members', 409);
        }

        $member = Member::create([
            'name' => $request->input('name'),
            'affiliation' => $request->input('affiliation'),
        ]);

        $memberWithAllColumns = Member::find($member->id);

        return response()->json($memberWithAllColumns, 201);
    }

    public function destroy(Request $request)
    {
        $validation = $this->myValidate($request, [
            'ids' => 'required|array',
            'ids.*' => 'required|integer',
        ]);

        if (!$validation['success']) {
            return response()->json($validation['error'], 422);
        }

        Member::whereIn('id', $request->input('ids'))->delete();
        return response()->json(['message' => 'Member deleted successfully'], 204);
    }

    public function update(Request $request)
    {
        $validation = $this->myValidate($request, [
            'id' => 'required|integer',
            'note' => 'required|string'
        ]);

        if (!$validation['success']) {
            return response()->json($validation['error'], 422);
        }

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
        $validation = $this->myValidate($request, [
            'ids' => 'required|array',
            'ids.*' => 'required|integer',
        ]);

        if (!$validation['success']) {
            return response()->json($validation['error'], 422);
        }

        Member::whereIn('id', $request->input('ids'))
            ->update(['authority' => 0]);

        return response()->json('Member approved successfully', 201);
    }
    public function rejection(Request $request)
    {
        $validation = $this->myValidate($request, [
            'ids' => 'required|array',
            'ids.*' => 'required|integer',
        ]);

        if (!$validation['success']) {
            return response()->json($validation['error'], 422);
        }

        Member::whereIn('id', $request->input('ids'))
            ->update(['authority' => 2]);

        return response()->json('Member rejected successfully', 201);
    }

    public function applicants()
    {
        $applicants = Member::where('authority', null)->get();

        return response()->json($applicants);
    }

    public function profile()
    {
        $member = auth()->user();

        if ($member) {
            return response()->json($member);
        } else {
            return response()->json(['error' => 'Not logged in'], 401);
        }
    }
}