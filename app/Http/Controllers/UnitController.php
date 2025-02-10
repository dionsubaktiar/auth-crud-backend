<?php

namespace App\Http\Controllers;

use App\Models\unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = unit::with('customers')->paginate(15);
        return response()->json([
            'message' => 'Unit data fetched successfully',
            'data' => $data,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nopol' => 'required|string|unique:units,nopol',
            'tipe' => 'required|string',
            'no_rangka' => 'required|string',
            'no_mesin' => 'required|string',
            'driver' => 'required|string',
            'tahun' => 'required|string',
            'japo_kir' => 'required|date',
            'japo_pajak' => 'required|date',
            'japo_stnk' => 'required|date',
            'japo_kontrak' => 'required|date',
            'status' => 'required|boolean',
            'id_customer' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = unit::create($request->all());
        return response()->json(['message' => 'Unit data registered successfully.', 'data' => $data], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = unit::with('customers')->find($id);

        if (!$data) {
            return response()->json(['message' => 'Unit data cant be found.'], 404);
        }

        return response()->json(['data' => $data], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $unit = unit::find($id);

        if (!$unit) {
            return response()->json(['message' => 'Unit data cant be found.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'tipe' => 'required|string',
            'no_rangka' => 'required|string',
            'no_mesin' => 'required|string',
            'driver' => 'required|string',
            'tahun' => 'required|string',
            'japo_kir' => 'required|date',
            'japo_pajak' => 'required|date',
            'japo_stnk' => 'required|date',
            'japo_kontrak' => 'required|date',
            'status' => 'required|boolean',
            'id_customer' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $unit->update($request->all());
        return response()->json(['message' => 'Unit data updated successfully.', 'data' => $unit], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = unit::find($id);

        if (!$data) {
            return response()->json(['message' => 'Unit data cant be found.'], 404);
        }
        $data->delete();
        return response()->json(['message' => 'Unit data deleted successfully', 200]);
    }
}
