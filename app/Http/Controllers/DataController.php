<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data; // Assuming the model is named `Data`
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Data::with('user')->get(); // Eager load related user
        return response()->json(['data' => $data, 'status'=>"Success"], 200);
    }

    /**
     * Show the form for creating a new resource (not needed for API).
     */
    public function create()
    {
        return response()->json(['message' => 'Form creation is not required for APIs.'], 405);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'article' => 'required|string',
            'tanggal' => $today,
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = Data::create($request->all());
        return response()->json(['message' => 'Data created successfully.', 'data' => $data], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Data::with('user')->find($id);

        if (!$data) {
            return response()->json(['message' => 'Data not found.'], 404);
        }

        return response()->json(['data' => $data], 200);
    }

    /**
     * Show the form for editing the specified resource (not needed for API).
     */
    public function edit(string $id)
    {
        return response()->json(['message' => 'Form editing is not required for APIs.'], 405);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Data::find($id);

        if (!$data) {
            return response()->json(['message' => 'Data not found.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'article' => 'sometimes|string',
            'tanggal' => 'sometimes|date',
            'user_id' => 'sometimes|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data->update($request->all());
        return response()->json(['message' => 'Data updated successfully.', 'data' => $data], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Data::find($id);

        if (!$data) {
            return response()->json(['message' => 'Data not found.'], 404);
        }

        $data->delete();
        return response()->json(['message' => 'Data deleted successfully.'], 200);
    }
}
