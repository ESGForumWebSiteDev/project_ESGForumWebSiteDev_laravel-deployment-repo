<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
  public function store(Request $request)
  {
    self::validateRequest($request);

    $about_us = AboutUs::create($request->all());

    return response()->json($about_us, 201);
  }

  public function index()
  {
    $about_us = AboutUs::all();

    return response()->json($about_us);
  }

  public function showObjective()
  {
    $objective = AboutUs::select('objective')->get()->last();

    return response()->json($objective);
  }

  public function showVision()
  {
    $vision = AboutUs::select('vision')->get()->last();

    return response()->json($vision);
  }


  public function showGreetings()
  {
    $greet = AboutUs::select('greetings')->get()->last();
    $chairman = AboutUs::select('chairman_position', 'chairman_name', 'chairman_image')->get()->last();

    $greetings = [
      'greetings' => $greet->greetings,
      'chairman' => [
        'position' => $chairman->chairman_position,
        'name' => $chairman->chairman_name,
        'image' => $chairman->chairman_image,
      ]
    ];

    return response()->json($greetings);
  }

  public function showRules()
  {
    $rules = AboutUs::select('rules')->get()->last();

    return response()->json($rules);

  }

  public function showCiLogo()
  {
    $ci_logo = AboutUs::select('ci_logo')->get()->last();

    return response()->json($ci_logo);
  }

  public function update(Request $request, $id)
  {
    self::validateRequest($request);

    try {
      $about_us = AboutUs::findOrFail($id);
      $about_us->update($request->all());
    } catch (\Exception $e) {
      return response()->json(['message' => 'AboutUs not found'], 404);
    }
  }

  public function validateRequest(Request $request)
  {
    $request->validate([
      'objective' => 'required|string',
      'vision' => 'required|string',
      'history_and_purpose' => 'required|string',
      'greetings' => 'required|string',
      'rules' => 'required|string',
      'ci_logo' => 'required|string',
    ]);
  }

}