<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
  public function store(Request $request)
  {
    self::validateRequest($request);

    if (!$request->hasFile('file')) {
      return response()->json(['upload_file_not_found'], 400);
    }

    $file = $request->file('file');

    $storedFileName = $file->store('files/' . date('Ym'));
    $storedPath = Storage::disk('local')->url($storedFileName);

    return response()->json($storedPath, 201);
  }

  public function destory(Request $request)
  {
    $url = $request->input('url');

    if (!Storage::exists($url)) {
      return response()->json(['file_not_found'], 404);
    }

    Storage::delete($url);

    return response()->json(['deleted_file'], 200);
  }

  public function validateRequest(Request $request)
  {
    $request->validate([
      'file' => 'required|mimes:jpeg,png,jpg,gif|max:5120',
    ]);
  }
}