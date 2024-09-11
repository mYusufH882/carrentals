<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mobil;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Traits\ResponseApi;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Pengembalian",
 *     description="API endpoints for managing pengembalian mobil"
 * )
 */

class PengembalianController extends Controller
{
    use ResponseApi;

    /**
     * List of Pengembalian Mobil
     * @OA\Get(
     *     path="/api/pengembalian",
     *     tags={"Pengembalian"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all pengembalian",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Success"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="peminjaman", type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="tgl_mulai", type="string", format="date", example="2024-09-01"),
     *                         @OA\Property(property="tgl_selesai", type="string", format="date", example="2024-09-05"),
     *                         @OA\Property(property="mobil", type="object",
     *                             @OA\Property(property="id", type="integer", example=1),
     *                             @OA\Property(property="merek", type="string", example="Toyota"),
     *                             @OA\Property(property="model", type="string", example="Camry"),
     *                             @OA\Property(property="nomor_plat", type="string", example="B 1234 XYZ")
     *                         ),
     *                         @OA\Property(property="user", type="object",
     *                             @OA\Property(property="id", type="integer", example=1),
     *                             @OA\Property(property="name", type="string", example="John Doe")
     *                         )
     *                     ),
     *                     @OA\Property(property="tgl_pengembalian", type="string", format="date", example="2024-09-10"),
     *                     @OA\Property(property="jumlah_total_sewa", type="number", format="float", example=500000.00)
     *                 )
     *             )
     *         )
     *     )
     * )
     */

    public function listPengembalianMobil()
    {
        $pengembalianQuery = Pengembalian::with(['peminjaman', 'peminjaman.mobil', 'peminjaman.user']);
        $pengembalian = $pengembalianQuery->get();

        return $this->success($pengembalian);
    }

    public function getCount()
    {
        $kembaliCount = Pengembalian::get()->count();

        return $this->success($kembaliCount);
    }

    /**
     * Store new Pengembalian Mobil
     * @OA\Post(
     *     path="/api/pengembalian",
     *     tags={"Pengembalian"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(property="nomor_plat", type="string", example="B 1234 XYZ")
     *                 ),
     *                 example={
     *                     "nomor_plat": "B 1234 XYZ"
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pengembalian created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Mobil berhasil dikembalikan !"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="peminjaman_id", type="integer", example=1),
     *                 @OA\Property(property="tgl_pengembalian", type="string", format="date", example="2024-09-10"),
     *                 @OA\Property(property="jumlah_total_sewa", type="number", format="float", example=500000.00)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Mobil not found or no active peminjaman",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=404),
     *             @OA\Property(property="message", type="string", example="Mobil Tidak Ditemukan !")
     *         )
     *     )
     * )
     */
    
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
