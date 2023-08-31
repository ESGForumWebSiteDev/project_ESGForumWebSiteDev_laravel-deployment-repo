<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::all();

        return response()->json($members);
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
}
