<?php

namespace App\Http\Controllers;

use App\Models\item;
use App\Models\servicepackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return servicepackage::with('items')->get();
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
            'kode_packages' => 'required|unique:servicepackages,kode_packages',
            'items' => 'required|array' // Ensure 'items' is an array
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create the service package
        $servicePackage = servicepackage::create([
            'kode_packages' => $request->kode_packages,
        ]);

        // Decode and iterate over the items
        $items = $request->items; // Already validated as an array
        foreach ($items as $item) {
            // Validate each item
            if (!isset($item['sparepart'], $item['harga_part'], $item['harga_jasa'])) {
                return response()->json(['message' => 'Invalid item data provided.'], 400);
            }

            // Create each item associated with the service package
            item::create([
                'sparepart' => $item['sparepart'],
                'harga_part' => $item['harga_part'],
                'harga_jasa' => $item['harga_jasa'],
                'kode_packages' => $servicePackage->kode_packages, // Link to the service package
            ]);
        }

        return response()->json([
            'message' => 'Service package and items created successfully.',
            'servicePackage' => $servicePackage,
            'items' => $servicePackage->items,
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = servicepackage::with('items')->find($id);
        if (!$data) {
            return response()->json(['message' => 'Package cant be found']);
        }
        return response()->json(['data' => $data]);
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
    public function update(Request $request, $id)
    {
        // $servicePackage = servicepackage::find($id);

        // if (!$servicePackage) {
        //     return response()->json(['message' => 'Service package not found'], 404);
        // }

        // $validator = Validator::make($request->all(), [
        //     'kode_packages' => "sometimes|unique:servicepackages,kode_packages,{$servicePackage->id}",
        //     'items' => 'sometimes|array', // Ensure 'items' is an array if provided
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 422);
        // }

        // // Update the items, if provided
        // if ($request->filled('items')) {
        //     $items = $request->items;

        //     foreach ($items as $item) {
        //         // Validate required fields for each item
        //         if (!isset($item['sparepart'], $item['harga_part'], $item['harga_jasa'])) {
        //             return response()->json(['message' => 'Invalid item data provided.'], 400);
        //         }

        //         // If `id` is present, update the existing item
        //         if (isset($item['id'])) {
        //             $existingItem = item::find($item['id']);
        //             if (!$existingItem) {
        //                 return response()->json(['message' => "Item with ID {$item['id']} not found."], 404);
        //             }

        //             $existingItem->update([
        //                 'sparepart' => $item['sparepart'],
        //                 'harga_part' => $item['harga_part'],
        //                 'harga_jasa' => $item['harga_jasa'],
        //                 'kode_packages' => $servicePackage->kode_packages, // Ensure linkage
        //             ]);
        //         } else {
        //             // If no `id`, create a new item
        //             item::create([
        //                 'sparepart' => $item['sparepart'],
        //                 'harga_part' => $item['harga_part'],
        //                 'harga_jasa' => $item['harga_jasa'],
        //                 'kode_packages' => $servicePackage->kode_packages, // Link to the service package
        //             ]);
        //         }
        //     }
        // }

        // // Update the service package, if `kode_packages` is provided
        // if ($request->filled('kode_packages')) {
        //     $servicePackage->update([
        //         'kode_packages' => $request->kode_packages,
        //     ]);
        // }


        // return response()->json([
        //     'message' => 'Service package updated successfully.',
        //     'servicePackage' => $servicePackage,
        //     'items' => $servicePackage->items,
        // ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = servicepackage::find($id);
        if (!$data) {
            return response()->json(['message' => 'Package not found']);
        }

        $data->delete();
        return response()->json(['message' => 'Package deleted successfully']);
    }
}
