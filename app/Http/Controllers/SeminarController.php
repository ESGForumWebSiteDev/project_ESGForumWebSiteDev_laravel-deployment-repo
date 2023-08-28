<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use Illuminate\Http\Request;

/**
 * TODO: 예외처리 추가해야 됨 (written on 2023/08/24 11:29 AM)
 */

class SeminarController extends Controller
{
  public function total()
  {
    $seminars = Seminar::count();

    return response()->json(['total' => $seminars]);
  }

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
    $seminars = Seminar::paginate(10);

    return response()->json($seminars);
  }

  public function show($id)
  {
    $seminar = Seminar::find($id);

    if (!$seminar) {
      return response()->json(['message' => 'Seminars not found'], 404);
    }

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

  public function validateRequest(Request $request)
  {
    $request->validate([
      'date_start' => 'required|date',
      'date_end' => 'required|date',
      'location' => 'required|string|max:40',
      'subject' => 'required|string|max:40',
      'host' => 'required|string|max:40',
      'supervision' => 'required|string|max:40',
      'participation' => 'required|string|max:40',
      'content' => 'required|string',
    ]);
  }
}