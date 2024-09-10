<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mobil;
use App\Models\Peminjaman;
use App\Traits\ResponseApi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeminjamanController extends Controller
{
    use ResponseApi;

    public function listPinjamMobil()
    {
        $pinjamQuery = Peminjaman::with(['user', 'mobil']);
        $pinjam = $pinjamQuery->get();
        
        return $this->success($pinjam);
    }

    public function peminjamanStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobil_id' => 'required|exists:mobils,id',
            'tgl_mulai' => 'required|date', 
            'tgl_selesai' => 'required|date|after:tgl_mulai',
        ]);

        if ($validator->fails()) {
            return $this->validationFailed($validator->errors());
        }

        $validatedData = $validator->validated();

        $tglMulai = Carbon::parse($validatedData['tgl_mulai']);
        $tglSelesai = Carbon::parse($validatedData['tgl_selesai']);
        $totalHariSewa = $tglMulai->diffInDays($tglSelesai);

        $mobil = Mobil::find($request->mobil_id);

        if(!$mobil) {
            return $this->notFound('Mobil Tidak Ditemukan !');
        }

        $mobil->update([
            'ketersediaan' => false
        ]);

        $pinjam = Peminjaman::create([
            'user_id' => auth()->user()->id,
            'mobil_id' => $validatedData['mobil_id'],
            'tgl_mulai' => $validatedData['tgl_mulai'], 
            'tgl_selesai' => $validatedData['tgl_selesai'],
            'total_hari_sewa' => $totalHariSewa,
            'status_sewa' => 'ongoing'
        ]);

        return $this->success($pinjam);
    }   
}
