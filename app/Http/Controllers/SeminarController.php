<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use App\Models\File;
use Illuminate\Http\Request;

/**
 * TODO: 예외처리 추가해야 됨 (written on 2023/08/24 11:29 AM)
 */

class SeminarController extends Controller
{
  public function store(Request $request)
  {
    self::validateRequest($request);

    try {
      $seminars = Seminar::create($request->all());
    } catch (\Exception $e) {
      return response()->json(['message' => 'Seminars creation failed'], 409);
    }

    return response()->json($seminars, 201);
  }

  public function index()
  {
    $seminars = Seminar::orderBy('id', 'desc')->paginate(10);

    return response()->json($seminars);
  }

  public function show($id)
  {
    $seminar = Seminar::find($id);

    if (!$seminar) {
      return response()->json(['message' => 'Seminars not found'], 404);
    }

    $files = File::where('post_id', $id)->get()->map(function ($file) {
      return ['url' => $file->url];
    });

    $seminar->files = $files;

    return response()->json($seminar);
  }

  public function update(Request $request, $id)
  {
    self::validateRequest($request);

    try {
      $seminar = Seminar::findOrFail($id);
    } catch (\Exception $e) {
      return response()->json(['message' => 'Seminars not found'], 404);
    }

    $seminar->update($request->all());

    return response()->json($seminar);
  }

  public function destroy($id)
  {
    $seminar = Seminar::findOrFail($id);
    $seminar->delete();

    return response()->json(['message' => 'Seminars deleted successfully']);
  }

  public function ongoingSeminars(Request $request)
  {
    $query = Seminar::where('date_start', '<=', now())->where('date_end', '>=', now());

    if ($request->has('subject')) {
      $query->where('subject', 'like', '%' . $request->get('subject') . '%');
    } else if ($request->has('host')) {
      $query->where('host', 'like', '%' . $request->get('host') . '%');
    }

    $seminars = $query->paginate(10);

    return response()->json($seminars);
  }

  public function pastSeminars(Request $request)
  {
    $query = Seminar::where('date_end', '<', now());

    if ($request->has('subject')) {
      $query->where('subject', 'like', '%' . $request->get('subject') . '%');
    } else if ($request->has('host')) {
      $query->where('host', 'like', '%' . $request->get('host') . '%');
    }

    $seminars = $query->paginate(10);

    return response()->json($seminars);
  }

  public function search(Request $request)
  {
    $query = Seminar::query();

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
      'date_start' => 'required|date',
      'date_end' => 'required|date',
      'location' => 'required|string|max:255',
      'subject' => 'required|string|max:255',
      'host' => 'required|string|max:255',
      'supervision' => 'required|string:max:255',
      'participation' => 'required|string',
      'content' => 'required|string',
    ]);
  }
}