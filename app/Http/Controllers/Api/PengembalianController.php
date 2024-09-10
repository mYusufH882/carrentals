<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mobil;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Traits\ResponseApi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    use ResponseApi;

    public function listPengembalianMobil()
    {
        $pengembalianQuery = Pengembalian::with(['peminjaman', 'peminjaman.mobil', 'peminjaman.user']);
        $pengembalian = $pengembalianQuery->get();

        return $this->success($pengembalian);
    }

    public function pengembalianStore(Request $request)
    {
        $validatedData = $request->validate([
            'nomor_plat' => 'required|exists:mobils,nomor_plat',
        ]);

        $mobil = Mobil::where('nomor_plat', $validatedData['nomor_plat'])
                        ->where('ketersediaan', false)
                        ->first();

        if (!$mobil) {
            return $this->notFound('Mobil Tidak Ditemukan !');
        }

        $peminjaman = Peminjaman::where('mobil_id', $mobil->id)
            ->where('user_id', auth()->user()->id)
            ->where('status_sewa', 'ongoing')
            ->first();

        if (!$peminjaman) {
            return $this->notFound('Tidak ada peminjaman aktif untuk mobil ini oleh pengguna.');
        }

        $tglMulai = Carbon::parse($peminjaman->tgl_mulai);
        $tglPengembalian = Carbon::now();
        $totalHariSewa = $tglMulai->diffInDays($tglPengembalian);

        $jumlahTotalSewa = round($totalHariSewa * $mobil->tarif_sewa_per_hari, 2); //Penghitungan jumlah total sewa

        $pengembalian = Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'tgl_pengembalian' => $tglPengembalian,
            'jumlah_total_sewa' => $jumlahTotalSewa,
        ]);

        $peminjaman->update([
            'status_sewa' => 'returned',
        ]);

        $mobil->update([
            'ketersediaan' => true,
        ]);

        return $this->success('Mobil berhasil dikembalikan !');
    }
}
