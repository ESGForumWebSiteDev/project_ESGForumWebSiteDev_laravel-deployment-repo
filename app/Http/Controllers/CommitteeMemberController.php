<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Committee;
use App\Models\Member;
use App\Models\CommitteeMember;

class CommitteeMemberController extends Controller
{
    public function index($id)
    {
        $committee = Committee::find($id);
        $members = $committee->members()->get();

        return response()->json($members, 200);
    }

    public function store($id, Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'affiliation' => 'required|string',
            'note' => 'sometimes|nullable|string|max:255',
        ]);
        
        $existingMember = Member::where('name', $request->input('name'))
        ->where('affiliation', $request->input('affiliation'))
        ->first();
        
        if (!$existingMember) {
            $newMember = Member::create([
                'name' => $request->input('name'),
                'affiliation' => $request->input('affiliation'),
            ]);
            
            $memberId = $newMember->id;
        } else {
            $memberId = $existingMember->id;
        }
        
        $isMember = CommitteeMember::where('cId', $id)->where('id2', $memberId)->first();

        if ($isMember) {
            return response()->json("", 403);
        }
        
        Committee::find($id)->members()->attach($memberId, ['note' => $request->input('note')]);
        $addedMember = Committee::find($id)->members()->where('id2', $memberId)->first();
        
        return response()->json($addedMember, 201);
    }

    public function update($c_id, $m_id)
    {
        $existingChairmanId = CommitteeMember::where('cId', $c_id)
            ->where('note', 1)
            ->first();

        if ($existingChairmanId) {
            CommitteeMember::where('cId', $c_id)
            ->where('note', 1)
            ->update(['note' => null]);
        }

        CommitteeMember::where('cId', $c_id)
            ->where('id2', $m_id)
            ->update(['note' => 1]);
            
        $newMemberInfo = Committee::find($c_id)->members()->get();

        return response()->json($newMemberInfo, 201);
    }

    public function destroy($c_id, $m_id)
    {
        Committee::find($c_id)->members()->detach([
            'cId'=> $c_id,
            'id2'=> $m_id,
        ]);

        return response()->json('Committee member deleted successfully', 204);
    }
}
