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
        $validation = $this->myValidate($request, [
            'name' => 'required|string',
            'affiliation' => 'required|string',
        ]);

        if (!$validation['success']) {
            return response()->json($validation['error'], 422);
        }

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
            return response()->json('conflict with existing members', 409);
        }

        Committee::find($id)->members()->attach($memberId);
        $addedMember = Committee::find($id)->members()->where('id2', $memberId)->first();

        return response()->json($addedMember, 201);
    }

    public function update($c_id, $m_id)
    {
        $existingChairmanId = CommitteeMember::where('cId', $c_id)
            ->where('note', '위원장')
            ->first();


        if ($existingChairmanId) {
            $existingChairmanId->note = '일반 회원';
            $existingChairmanId->save();
        }

        CommitteeMember::where('cId', $c_id)
            ->where('id2', $m_id)
            ->update(['note' => '위원장']);

        $newMemberInfo = Committee::find($c_id)->members()->get();

        return response()->json($newMemberInfo, 201);
    }

    public function destroy($c_id, Request $request)
    {
        $validation = $this->myValidate($request, [
            'ids' => 'required|array',
            'ids.*' => 'required|integer',
        ]);

        if (!$validation['success']) {
            return response()->json($validation['error'], 422);
        }

        CommitteeMember::where('cId', $c_id)->whereIn('id2', $request->input('ids'))->delete();
        return response()->json('Committee member deleted successfully', 204);
    }
}
