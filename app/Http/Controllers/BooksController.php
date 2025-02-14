<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Books::all();
        return response()->json([
            "message" => "Books fetched successfully",
            "data" => $data
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
            'title' => 'required|string|max:200',
            'author' => 'required|string|max:100',
            'genre' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $request->merge(['vote_count' => 0]);
        $data = Books::create($request->all());
        return response()->json($data, 201);
    }

    public function search(Request $request)
    {
        $data = Books::where('title', 'like', $request->title . '%')->get();
        return response()->json(['data' => $data], 200);
    }

    public function likes($id)
    {
        $data = Books::find($id);
        if (!$data) {
            return response()->json(['message' => 'ID book tidak ada'], 404);
        }
        $like = $data->vote_count;
        $new_like = $like + 1;
        $data->update(['vote_count' => $new_like]);
        return response()->json(["message" => "berhasil like"], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Books::find($id);
        if (!$data) {
            return response()->json(['message' => 'ID book tidak ada'], 404);
        }
        $data->delete();
        return response()->json(['message' => 'Books has been deleted successfully'], 200);
    }
}
