<?php

namespace App\Http\Controllers;

use App\Models\pinjaman;
use App\Models\kendaraan;
use Illuminate\Http\Request;

class PinjamanController extends Controller
{
    public function index()
    {
        $pinjaman = Pinjaman::with('kendaraan', 'konsumen')->get();

        return response()->json($pinjaman);
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'asuransi' => 'required|numeric',
            'down_payment' => 'required|numeric',
            'tenor' => 'required|integer',
            'id_kendaraan' => 'required|exists:kendaraan,id',
            'id_user' => 'required|exists:konsumen,id',
        ]);

        // Find the selected kendaraan by id
        $kendaraan = kendaraan::findOrFail($request->id_kendaraan);

        // Calculate the angsuran (installment)
        $hargaKendaraan = $kendaraan->harga_kendaraan;
        $downPayment = $request->down_payment;
        $tenor = $request->tenor;

        // Ensure the down payment is not greater than the vehicle price
        if ($downPayment > $hargaKendaraan) {
            return response()->json(['error' => 'Down payment cannot be greater than the vehicle price.'], 400);
        }

        // Calculate angsuran
        $angsuran = ($hargaKendaraan - $downPayment) / $tenor;

        // Create the new Pinjaman record
        $pinjaman = pinjaman::create([
            'asuransi' => $request->asuransi,
            'down_payment' => $downPayment,
            'tenor' => $tenor,
            'angsuran' => $angsuran,
            'id_kendaraan' => $request->id_kendaraan,
            'id_user' => $request->id_user,
        ]);

        return response()->json($pinjaman, 201);
    }

    public function show($id)
    {
        return pinjaman::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $pinjaman = pinjaman::findOrFail($id);

        // Validate the incoming request data
        $request->validate([
            'asuransi' => 'required|numeric',
            'down_payment' => 'required|numeric',
            'tenor' => 'required|integer',
            'id_kendaraan' => 'required|exists:kendaraans,id',
            'id_user' => 'required|exists:konsumen,id',
        ]);

        // Find the selected kendaraan by id
        $kendaraan = kendaraan::findOrFail($request->id_kendaraan);

        // Calculate the new angsuran (installment)
        $hargaKendaraan = $kendaraan->harga_kendaraan;
        $downPayment = $request->down_payment;
        $tenor = $request->tenor;

        // Ensure the down payment is not greater than the vehicle price
        if ($downPayment > $hargaKendaraan) {
            return response()->json(['error' => 'Down payment cannot be greater than the vehicle price.'], 400);
        }

        // Calculate angsuran
        $angsuran = ($hargaKendaraan - $downPayment) / $tenor;

        // Update the Pinjaman record
        $pinjaman->update([
            'asuransi' => $request->asuransi,
            'down_payment' => $downPayment,
            'tenor' => $tenor,
            'angsuran' => $angsuran,
            'id_kendaraan' => $request->id_kendaraan,
            'id_user' => $request->id_user,
        ]);

        return response()->json($pinjaman, 200);
    }

    public function destroy($id)
    {
        pinjaman::destroy($id);
        return response()->json(null, 204);
    }
}
