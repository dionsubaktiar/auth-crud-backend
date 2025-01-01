<?php

namespace App\Http\Controllers;

use App\Models\angsuran;
use App\Models\kontrak;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class IMSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $index_kontrak =  kontrak::with('angsuran')->paginate(10);
        return response()->json(['data_kontrak'=>$index_kontrak, 'status'=>'success'],200);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    private function generateKontrakID()
    {
        $id = kontrak::latest()->value('id');
        $nextId = $id + 1;
        if ($nextId > 9 & $nextId < 100) {
            $kodeInv = 'AGR00' . strval($nextId);
        } elseif ($nextId > 99 & $nextId < 1000) {
            $kodeInv = 'AGR0' . strval($nextId);
        } elseif ($nextId > 999 & $nextId < 10000) {
            $kodeInv = 'AGR' . strval($nextId);
        } else {
            $kodeInv = 'AGR000' . strval($nextId);
        }
        return $kodeInv;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_name'=>'required|string:255',
            'otr'=>'required|numeric',
            'dp'=>'required|numeric',
            'durasi'=>'required|numeric',
            'tgl_mulai'=>'required|date'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = kontrak::create(array_merge($request->all(), ['kontrak_no' => $this->generateKontrakID()]));

        $otr = $request->otr;
        $dp = $request->dp;
        $durasi = $request->durasi;
        $tanggal = Carbon::parse($request->tgl_mulai);
        $financedAmount = $otr - $dp;

        if($durasi<=12){
            $angsuran = ($financedAmount+(12/100*$financedAmount))/$durasi;
            for ($i = 1; $i <= $durasi; $i++) {
                angsuran::create([
                    'kontrak_id' => $data->kontrak_no,
                    'angsuran_ke' => $i,
                    'nominal' => round($angsuran, 2),
                    'tanggal_jatuh_tempo' => $tanggal->copy()->addMonths($i - 1)->toDateString(),
                ]);
            }
        }
        elseif($durasi>=12 && $durasi<=24){
            $angsuran = ($financedAmount+(14/100*$financedAmount))/$durasi;
            for ($i = 1; $i <= $durasi; $i++) {
                angsuran::create([
                    'kontrak_id' => $data->kontrak_no,
                    'angsuran_ke' => $i,
                    'nominal' => round($angsuran, 2),
                    'tanggal_jatuh_tempo' => $tanggal->copy()->addMonths($i - 1)->toDateString(),
                ]);
            }
        }else{
            $angsuran = ($financedAmount+(16.5/100*$financedAmount))/$durasi;
            for ($i = 1; $i <= $durasi; $i++) {
                angsuran::create([
                    'kontrak_id' => $data->kontrak_no,
                    'angsuran_ke' => $i,
                    'nominal' => round($angsuran, 2),
                    'tanggal_jatuh_tempo' => $tanggal->copy()->addMonths($i - 1)->toDateString(),
                ]);
            }
        }
        return response()->json(['message' => 'Kontrak and Angsuran created successfully.','data_kontrak'=>$data], 201);
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
        //
    }
}
