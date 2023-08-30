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

    $path = 'files/' . date('Ym');

    try {
      $filepath = Storage::disk('s3')->put($path, $file);
    } catch (\Exception $e) {
      return response()->json(['upload_file_failed' => $e->getMessage()], 400);
    }

    $url = env('AWS_CLOUDFRONT_S3_URL') . '/' . $filepath;

    return response()->json($url, 201);
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