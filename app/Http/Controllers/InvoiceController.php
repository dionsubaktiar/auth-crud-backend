<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use App\Models\item;
use App\Models\part;
use App\Models\servicepackage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function Pest\Laravel\json;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = invoice::with('units', 'packages')->paginate(15);
        return response()->json([
            'messages' => 'Invoice data fetched successfully',
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
     * Generate a unique kode_invoice based on the current date.
     *
     * @return string
     */
    private function generateKodeInvoice(): string
    {
        $id = invoice::latest()->value('id');
        $nextId = $id ? $id + 1 : 1;

        // Get the current month and year
        $currentMonth = Carbon::now()->format('m'); // Month as 2 digits
        $currentYear = Carbon::now()->format('Y'); // Full year

        // Generate the kode_invoice (e.g., INV-202501-0001)
        return 'INV-' . $currentYear . $currentMonth . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Generate a unique kode_invoice based on the current date.
     *
     * @return string
     */
    private function generateKodeSPK(): string
    {
        $id = invoice::latest()->value('id');
        $nextId = $id ? $id + 1 : 1;

        // Get the current month and year
        $currentMonth = Carbon::now()->format('m'); // Month as 2 digits
        $currentYear = Carbon::now()->format('Y'); // Full year

        // Generate the kode_invoice (e.g., INV-202501-0001)
        return 'SPK-' . $currentYear . $currentMonth . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kilometer' => 'required|numeric',
            'tanggal' => 'required|date',
            'id_unit' => 'required|numeric',
            'id_package' => 'sometimes|numeric',
            'id_part' => 'sometimes|string',
            'harga' => 'sometimes|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $total_harga = 0;

        // Calculate total_harga based on the service package
        if ($request->id_package) {
            $find_package = ServicePackage::find($request->id_package);
            if (!$find_package) {
                return response()->json(['message' => 'Package not found'], 404);
            }

            $items = item::where('kode_packages', '=', $find_package->kode_packages)->get();
            foreach ($items as $item) {
                $harga = $item->harga_part + $item->harga_jasa;
                $total_harga += $harga;
            }
        }

        // Calculate total_harga based on the parts
        if ($request->id_part) {
            $id_part_array = json_decode(json_encode($request->id_part), true); // Decode JSON string to an array
            foreach ($id_part_array as $partDetails) {
                $part = Part::find($partDetails['id_part']);
                if (!$part) {
                    return response()->json(['message' => "Part with ID {$partDetails['id_part']} not found"], 404);
                }

                $qty = $partDetails['qty'] ?? 1; // Default quantity is 1 if not provided
                $sum = ($part->harga * $qty) + $part->jasa;
                $total_harga += $sum;

                // Add the individual price (`hargaKey`) to the part details
                $partDetails['harga_key'] = $sum;
            }

            // Update the request with the updated parts and total harga
            $request->merge([
                'id_part' => json_encode($id_part_array),
            ]);
        }

        $request->merge([
            'kode_invoice' => $this->generateKodeInvoice(),
            'kode_spk' => $this->generateKodeSPK(),
            'harga' => $total_harga,
            'status_invoice' => 'Pending',
            'status_spk' => 'Pending'
        ]);

        $data = invoice::create($request->all());
        return response()->json([
            'message' => 'Invoice data created successfully',
            'data' => $data,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = invoice::with('units', 'packages')->find($id);
        $package = servicepackage::find($data->id_package);

        if (!$data) {
            return response()->json(['message' => 'Invoice data cant be found'], 404);
        }

        if (!$package) {
            return response()->json(['message' => 'Package data cant be found'], 404);
        }

        $items = item::where('kode_packages', '=', $package->kode_packages)->get();
        $data->package_items = $items;

        // Decode the id_part JSON
        $idParts = json_decode($data->id_part, true);

        // Find each part and attach its details
        $partsDetails = [];
        foreach ($idParts as $part) {
            $partDetails = part::find($part['id_part']);
            if (!$partDetails) {
                return response()->json(['message' => "Part with ID {$partDetails['id_part']} not found"], 404);
            }
            if ($partDetails) {
                $partsDetails[] = [
                    'id_part' => $partDetails->id,
                    'name' => $partDetails->nama_barang,
                    'quantity' => $part['qty'],
                    'total_price' => $part['harga_key']
                ];
            }
        }

        // Add parts details to the response
        $data->parts = $partsDetails;

        return response()->json([
            'message' => 'Invoice data found',
            'data' => $data,
        ], 200);
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
        $invoice = invoice::find($id);
        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'kilometer' => 'sometimes|numeric',
            'tanggal' => 'sometimes|date',
            'id_unit' => 'sometimes|numeric',
            'id_package' => 'sometimes|numeric',
            'id_part' => 'sometimes',
            'harga' => 'sometimes|numeric',
            'status_invoice' => 'sometimes|string',
            'status_spk' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $total_harga = 0;

        // Recalculate total_harga for the service package, if provided
        if ($request->id_package) {
            $find_package = servicepackage::find($request->id_package);
            if (!$find_package) {
                return response()->json(['message' => 'Package not found'], 404);
            }

            $items = item::where('kode_packages', '=', $find_package->kode_packages)->get();
            foreach ($items as $item) {
                $harga = $item->harga_part + $item->harga_jasa;
                $total_harga += $harga;
            }
        }

        // Calculate total_harga based on the parts
        if ($request->id_part) {
            $id_part_array = json_decode(json_encode($request->id_part), true); // Decode JSON string to an array
            foreach ($id_part_array as &$partDetails) {
                $part = Part::find($partDetails['id_part']);
                if (!$part) {
                    return response()->json(['message' => "Part with ID {$partDetails['id_part']} not found"], 404);
                }

                $qty = $partDetails['qty'] ?? 1; // Default quantity is 1 if not provided
                $sum = ($part->harga * $qty) + $part->jasa;
                $total_harga += $sum;

                // Add the individual price (`hargaKey`) to the part details
                $partDetails['harga_key'] = $sum;
            }

            // Update the request with the updated parts and total harga
            $request->merge([
                'id_part' => json_encode($id_part_array),
            ]);
        }

        // Merge additional fields into the request
        $request->merge([
            'harga' => $total_harga,
        ]);

        // Update the invoice with the request data
        $invoice->update($request->all());

        return response()->json([
            'message' => 'Invoice data updated successfully',
            'data' => $invoice,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = invoice::find($id);

        if (!$data) {
            return response()->json(['message' => 'Unit data cant be found.'], 404);
        }
        $data->delete();
        return response()->json(['message' => 'Unit data deleted successfully', 200]);
    }

    public function accept_status_spk($id)
    {
        $data = invoice::find($id);

        if (!$data) {
            return response()->json(['message' => 'Unit data cant be found.'], 404);
        }

        $data->update([
            'status_spk' => 'Accepted'
        ]);

        return response()->json(['message' => 'SPK Accepted.'], 200);
    }

    public function cancel_status($id)
    {
        $data = invoice::find($id);

        if (!$data) {
            return response()->json(['message' => 'Unit data cant be found.'], 404);
        }

        $data->update([
            'status_invoice' => 'Canceled',
            'status_spk' => 'Canceled'
        ]);

        return response()->json(['message' => 'Order Canceled.'], 200);
    }

    public function set_spk_done($id)
    {
        $data = invoice::find($id);

        if (!$data) {
            return response()->json(['message' => 'Unit data cant be found.'], 404);
        }

        $data->update([
            'status_invoice' => 'Accepted',
            'status_spk' => 'Done'
        ]);

        return response()->json(['message' => 'SPK Done, Invoice Granted.'], 200);
    }

    public function set_invoice_clear($id)
    {
        $data = invoice::find($id);
        if (!$data) {
            return response()->json(['message' => 'Unit data cant be found.'], 404);
        }

        $data->update([
            'status_invoice' => 'Done',
        ]);

        return response()->json(['message' => 'Order Done.'], 200);
    }
}
