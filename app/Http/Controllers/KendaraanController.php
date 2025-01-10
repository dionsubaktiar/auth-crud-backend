<?php

namespace App\Http\Controllers;

use App\Models\kendaraan;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function index()
    {
        return kendaraan::all();
    }

    public function store(Request $request)
    {
        $kendaraan = kendaraan::create($request->all());
        return response()->json($kendaraan, 201);
    }

    public function show($id)
    {
        return kendaraan::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $kendaraan = kendaraan::findOrFail($id);
        $kendaraan->update($request->all());
        return response()->json($kendaraan, 200);
    }

    public function destroy($id)
    {
        kendaraan::destroy($id);
        return response()->json(null, 204);
    }
}
