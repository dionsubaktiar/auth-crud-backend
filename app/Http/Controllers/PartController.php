<?php

namespace App\Http\Controllers;

use App\Models\part;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = part::paginate(20);
        return response()->json([
            'messages' => 'Part data fetched successfully',
            'data' => $data,
        ], 200);
        // return part::all();
    }

    public function getAll()
    {
        $data = part::select('id', 'nama_barang')->get();
        return response()->json([
            'messages' => 'Part data fetched successfully',
            'data' => $data,
        ], 200);
        // return part::all();
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
            'part_number' => 'string',
            'merk' => 'required|string',
            'kendaraan' => 'required|string',
            'harga' => 'required|numeric',
            'jasa' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = part::create($request->all());
        return response()->json(['message' => 'Part data created successfully', 201]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = part::find($id);
        if (!$data) {
            return response()->json(['message' => 'Part data cant be found'], 404);
        }
        return response()->json(['data' => $data], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = part::find($id);

        if (!$data) {
            return response()->json(['message' => 'Part data cant be found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'part_number' => 'string',
            'merk' => 'required|string',
            'kendaraan' => 'required|string',
            'harga' => 'required|numeric',
            'jasa' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data->update($request->all());
        return response()->json([
            'message' => 'Part data updated successfully',
            'data' => $data
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = part::find($id);

        if (!$data) {
            return response()->json(['message' => 'Part data cant be found'], 404);
        }
        $data->delete();
        return response()->json(['message' => 'Part data deleted successfully']);
    }
}
