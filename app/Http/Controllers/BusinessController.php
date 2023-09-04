<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
  public function store(Request $request)
  {
    $request->validate([
      'kind' => 'required|string|max:40',
      'content' => 'required|string',
    ]);

    $business = Business::create($request->all());

    return response()->json($business, 201);
  }

  public function index()
  {
    $business = Business::all();

    return response()->json($business);
  }

  public function update(Request $request, Business $business)
  {
    $request->validate([
      'kind' => 'required|string|max:40',
      'content' => 'required|string',
    ]);

    $business->update($request->all());

    return response()->json($business);
  }

  public function destroy(Business $business)
  {
    $business->delete();

    return response()->json(['message' => 'Business deleted successfully']);
  }
}