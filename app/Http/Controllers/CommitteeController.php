<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use Illuminate\Http\Request;

class CommitteeController extends Controller
{
    public function count()
    {
        $count = Committee::count();
        return response()->json($count);
    }

    public function store(Request $request)
    {
        $validation = $this->myValidate($request, [
            'name' => 'required|string|max:255',
            'explanation' => 'required|string',
        ]);

        if (!$validation['success']) {
            return response()->json($validation['error'], 422);
        }

        $committee = Committee::create($request->all());

        return response()->json($committee, 201);
    }

    public function index()
    {
        $committees = Committee::all();

        return response()->json($committees);
    }

    public function find($id)
    {
        $committee = Committee::find($id);

        if (!$committee) {
            return response()->json('Not Found', 404);
        }

        return response()->json($committee);
    }

    public function update(Request $request, $id)
    {
        $validation = $this->myValidate($request, [
            'name' => 'required|string|max:255',
            'explanation' => 'required|string',
        ]);

        if (!$validation['success']) {
            return response()->json($validation['error'], 422);
        }

        $committee = Committee::where('id', $id)
            ->update([
                'name' => $request->input('name'),
                'explanation' => $request->input('explanation')
            ]);

        return response()->json($committee, 201);
    }

    public function destroy($id)
    {
        Committee::find($id)->delete();
        return response()->json(['message' => 'Committee deleted successfully'], 204);
    }

    public function getMember()
    {
        $committees = Committee::with('members')->get();

        return response()->json($committees);
    }
}
