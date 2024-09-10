<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mobil;
use App\Models\Peminjaman;
use App\Traits\ResponseApi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Peminjaman",
 *     description="API endpoints for managing peminjaman mobil"
 * )
 */
class PeminjamanController extends Controller
{
    use ResponseApi;

    /**
     * List of Peminjaman Mobil
     * @OA\Get(
     *     path="/api/peminjaman",
     *     tags={"Peminjaman"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all peminjaman",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Success"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="user", type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="name", type="string", example="John Doe")
     *                     ),
     *                     @OA\Property(property="mobil", type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="merek", type="string", example="Toyota"),
     *                         @OA\Property(property="model", type="string", example="Camry")
     *                     ),
     *                     @OA\Property(property="tgl_mulai", type="string", format="date", example="2024-09-01"),
     *                     @OA\Property(property="tgl_selesai", type="string", format="date", example="2024-09-05"),
     *                     @OA\Property(property="total_hari_sewa", type="integer", example=4),
     *                     @OA\Property(property="status_sewa", type="string", example="ongoing")
     *                 )
     *             )
     *         )
     *     )
     * )
     */

    public function listPinjamMobil()
    {
        $pinjamQuery = Peminjaman::with(['user', 'mobil']);
        $pinjam = $pinjamQuery->get();
        
        return $this->success($pinjam);
    }

    /**
     * Store new Peminjaman Mobil
     * @OA\Post(
     *     path="/api/peminjaman",
     *     tags={"Peminjaman"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(property="mobil_id", type="integer", example=1),
     *                      @OA\Property(property="tgl_mulai", type="string", format="date", example="2024-09-01"),
     *                      @OA\Property(property="tgl_selesai", type="string", format="date", example="2024-09-05")
     *                 ),
     *                 example={
     *                     "mobil_id": 1,
     *                     "tgl_mulai": "2024-09-01",
     *                     "tgl_selesai": "2024-09-05"
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Peminjaman created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Success"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="mobil_id", type="integer", example=1),
     *                 @OA\Property(property="tgl_mulai", type="string", format="date", example="2024-09-01"),
     *                 @OA\Property(property="tgl_selesai", type="string", format="date", example="2024-09-05"),
     *                 @OA\Property(property="total_hari_sewa", type="integer", example=4),
     *                 @OA\Property(property="status_sewa", type="string", example="ongoing")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=422),
     *             @OA\Property(property="message", type="string", example="Validation failed."),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="mobil_id", type="array", collectionFormat="multi",
     *                    @OA\Items(type="string", example="The mobil_id field is required.")
     *                 ),
     *                 @OA\Property(property="tgl_mulai", type="array", collectionFormat="multi",
     *                    @OA\Items(type="string", example="The tgl_mulai field is required.")
     *                 ),
     *                 @OA\Property(property="tgl_selesai", type="array", collectionFormat="multi",
     *                    @OA\Items(type="string", example="The tgl_selesai field is required.")
     *                 )
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Mobil not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=404),
     *             @OA\Property(property="message", type="string", example="Mobil Tidak Ditemukan !")
     *         )
     *     )
     * )
     */
    
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
