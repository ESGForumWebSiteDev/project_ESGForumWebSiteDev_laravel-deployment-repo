<?php

namespace App\Http\Controllers;

use App\Models\Histories;
use Illuminate\Http\Request;

class HistoriesController extends Controller
{
  public function index()
  {
    $histories = Histories::all();

    return response()->json($histories);
  }

  public function show($id)
  {
    $histories = Histories::find($id);

    return response()->json($histories);
  }

  public function store(Request $request)
  {
    self::validateRequest($request);

    $history = Histories::create($request->all());

    return response()->json($history, 201);
  }

  public function validateRequest(Request $request)
  {
    $request->validate([
      'date' => 'required',
      'content' => 'required'
    ]);
  }
}