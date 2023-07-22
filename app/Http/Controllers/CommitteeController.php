<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\Member;
use Illuminate\Http\Request;

class CommitteeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'explanation' => 'required|string',
        ]);

        $committee = Committee::create($request->all());

        return response()->json($committee, 201);
    }

    public function index()
    {
        $committees = Committee::with(['members'])->get();

        return response()->json($committees);
    }

    public function update(Request $request, Committee $committee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'explanation' => 'required|string',
        ]);

        $committee->update($request->all());

        return response()->json($committee);
    }

    public function destroy(Committee $committee)
    {
        $committee->delete();

        return response()->json(['message' => 'Committee deleted successfully']);
    }

    public function storeMember(Request $request, Committee $committee)
    {
        $request->validate([
            'member_id' => 'required|integer|exists:members,id',
            'note' => 'sometimes|nullable|string|max:255',
        ]);

        $committee->members()->attach($request->input('member_id', ['note' => $request->input('note')]));

        return response()->json(['message' => 'Committee member added successfully'], 201);
    }

    public function updateMember(Request $request, Committee $committee, Member $member)
    {
        $request->validate([
            'note' => 'required|string|max:255',
        ]);

        $committee->members()->updateExistingPivot($member->id, ['note' => $request->input('note')]);

        return response()->json(['message' => 'Committee member updated successfully']);
    }

    public function destroyMember(Committee $committee, Member $member)
    {
        $committee->members()->detach($member->id);

        return response()->json(['message' => 'Committee member deleted successfully']);
    }
}
