<?php

namespace App\Http\Controllers;

use App\Models\Committee;
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
}
