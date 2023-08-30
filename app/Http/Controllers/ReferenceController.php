<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class ReferenceController extends Controller
{
    public function total()
    {
        $references = Post::count();

        return response()->json(['total' => $references]);
    }

    public function store(Request $request)
    {
        self::validateRequest($request);

        try {
            $references = Post::create($request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => 'References creation failed'], 409);
        }

        return response()->json($references, 201);
    }

    public function index()
    {
        $references = Post::orderBy('id', 'desc')->paginate(10);

        return response()->json($references);
    }

    public function show($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'References not found'], 404);
        }

        return response()->json($post);
    }

    public function update(Request $request, $id)
    {
        self::validateRequest($request);

        try {
            $post = Post::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json(['message' => 'References not found'], 404);
        }

        $post->update($request->all());

        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json(['message' => 'References deleted successfully']);
    }

    public function search(Request $request)
    {
        $query = Post::query();

        if ($request->has('subject')) {
            $query->where('subject', 'like', '%' . $request->get('subject') . '%');
        }

        if ($request->has('host')) {
            $query->where('host', 'like', '%' . $request->get('host') . '%');
        }

        return response()->json($query->paginate(10));
    }

    public function validateRequest(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'required|string|max:40',
            'view' => 'required|int|min:0',
        ]);
    }
}