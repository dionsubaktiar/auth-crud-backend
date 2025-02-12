<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = customer::paginate(15);
        return response()->json([
            'message' => 'Customers data fetched successfully',
            'data' => $data
        ], 200);
    }

    public function getAll()
    {
        $data = customer::select('id', 'nama_perusahaan')->get();
        return response()->json([
            'message' => 'Customers data fetched successfully',
            'data' => $data
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
            'nama_perusahaan' => 'required|string',
            'alamat' => 'required|string',
            'pic' => 'required|string',
            'kontak' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = customer::create($request->all());

        return response()->json(['message' => 'Customer data registered successfully.', 'data' => $data], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = customer::find($id);
        if (!$data) {
            return response()->json(['message' => 'Customer data not found.'], 404);
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
        $data = customer::find($id);
        if (!$data) {
            return response()->json(['message' => 'Data not found.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_perusahaan' => 'sometimes|string',
            'alamat' => 'sometimes|string',
            'pic' => 'sometimes|string',
            'kontak' => 'sometimes|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data->update($request->all());
        return response()->json(['message' => 'Customer data updated successfully.', 'data' => $data], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = customer::find($id);

        if (!$data) {
            return response()->json(['message' => 'Customer data not found.'], 404);
        }

        $data->delete();
        return response()->json(['message' => 'Customer data deleted successfully.'], 200);
    }
}
