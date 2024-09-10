<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mobil;
use App\Traits\ResponseApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Mobil",
 *     description="Mobil Management CRUD"
 * )
 */

class MobilController extends Controller
{
    use ResponseApi;


    /**
     * Get list of Mobil
     * @OA\Get(
     *     path="/api/mobils",
     *     tags={"Mobil"},
     *     @OA\Parameter(
     *         name="merek",
     *         in="query",
     *         description="Filter by merek",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="model",
     *         in="query",
     *         description="Filter by model",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="ketersediaan",
     *         in="query",
     *         description="Filter by ketersediaan (availability)",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of Mobil",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Data Mobil Successfully"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="merek", type="string", example="Toyota"),
     *                     @OA\Property(property="model", type="string", example="Camry"),
     *                     @OA\Property(property="nomor_plat", type="string", example="ABC1234"),
     *                     @OA\Property(property="tarif_sewa_per_hari", type="number", format="float", example=500000),
     *                     @OA\Property(property="ketersediaan", type="boolean", example=true)
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $mobilQuery = Mobil::query();

        if ($request->has('merek')) {
            $mobilQuery
                ->where('merek', 'like', '%' . $request->query('merek') . '%');
        }

        if($request->has('model')) {
            $mobilQuery
                ->where('model', 'like', '%' . $request->query('model') . '%');
        }

        if($request->has('ketersediaan')) {
            $mobilQuery
                ->where('ketersediaan', 'like', '%' . $request->query('ketersediaan') . '%');
        }

        $mobils = $mobilQuery->get();

        return $this->success($mobils, 'Data Mobil Successfully');
    }

    /**
     * Store a new Mobil
     * @OA\Post(
     *     path="/api/mobils",
     *     tags={"Mobil"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(property="merek", type="string"),
     *                      @OA\Property(property="model", type="string"),
     *                      @OA\Property(property="nomor_plat", type="string"),
     *                      @OA\Property(property="tarif_sewa_per_hari", type="number", format="float"),
     *                      @OA\Property(property="ketersediaan", type="boolean")
     *                 ),
     *                 example={
     *                     "merek": "Toyota",
     *                     "model": "Camry",
     *                     "nomor_plat": "ABC1234",
     *                     "tarif_sewa_per_hari": 500000,
     *                     "ketersediaan": true
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Mobil created successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example=201),
     *              @OA\Property(property="message", type="string", example="Data Mobil Berhasil Dibuat."),
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="merek", type="string", example="Toyota"),
     *                  @OA\Property(property="model", type="string", example="Camry"),
     *                  @OA\Property(property="nomor_plat", type="string", example="ABC1234"),
     *                  @OA\Property(property="tarif_sewa_per_hari", type="number", format="float", example=500000),
     *                  @OA\Property(property="ketersediaan", type="boolean", example=true)
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example=422),
     *              @OA\Property(property="message", type="string", example="Validation failed."),
     *              @OA\Property(property="errors", type="object",
     *                  @OA\Property(property="merek", type="array", collectionFormat="multi",
     *                    @OA\Items(type="string", example="The merek field is required.")
     *                  ),
     *                  @OA\Property(property="model", type="array", collectionFormat="multi",
     *                    @OA\Items(type="string", example="The model field is required.")
     *                  ),
     *                  @OA\Property(property="nomor_plat", type="array", collectionFormat="multi",
     *                    @OA\Items(type="string", example="The nomor plat field is required.")
     *                  ),
     *                  @OA\Property(property="tarif_sewa_per_hari", type="array", collectionFormat="multi",
     *                    @OA\Items(type="string", example="The tarif sewa per hari field is required.")
     *                  ),
     *                  @OA\Property(property="ketersediaan", type="array", collectionFormat="multi",
     *                    @OA\Items(type="string", example="The ketersediaan field is required.")
     *                  )
     *              ),
     *          )
     *      )
     * )
     */

    public function store(Request $request)
    {
        $validData = $request->validate([
            'merek' => 'required|string',
            'model' => 'required|string',
            'nomor_plat' => 'required|string',
            'tarif_sewa_per_hari' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'ketersediaan' => 'required|boolean'
        ]);

        $mobil = Mobil::create($validData);

        return $this->success($mobil, 'Data Mobil Berhasil Dibuat.');
    }

    /**
     * Edit an existing Mobil
     * @OA\Put(
     *     path="/api/mobils/{id}",
     *     tags={"Mobil"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of Mobil to edit",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(property="merek", type="string"),
     *                      @OA\Property(property="model", type="string"),
     *                      @OA\Property(property="nomor_plat", type="string"),
     *                      @OA\Property(property="tarif_sewa_per_hari", type="number", format="float"),
     *                      @OA\Property(property="ketersediaan", type="boolean")
     *                 ),
     *                 example={
     *                     "merek": "Toyota",
     *                     "model": "Camry",
     *                     "nomor_plat": "ABC1234",
     *                     "tarif_sewa_per_hari": 500000,
     *                     "ketersediaan": true
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Mobil updated successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example=200),
     *              @OA\Property(property="message", type="string", example="Data Mobil Berhasil Diubah."),
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="merek", type="string", example="Toyota"),
     *                  @OA\Property(property="model", type="string", example="Camry"),
     *                  @OA\Property(property="nomor_plat", type="string", example="ABC1234"),
     *                  @OA\Property(property="tarif_sewa_per_hari", type="number", format="float", example=500000),
     *                  @OA\Property(property="ketersediaan", type="boolean", example=true)
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Mobil not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example=404),
     *              @OA\Property(property="message", type="string", example="Mobil Tidak Ditemukan !")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example=422),
     *              @OA\Property(property="message", type="string", example="Validation failed."),
     *              @OA\Property(property="errors", type="object",
     *                  @OA\Property(property="merek", type="array", collectionFormat="multi",
     *                    @OA\Items(type="string", example="The merek field is required.")
     *                  ),
     *                  @OA\Property(property="model", type="array", collectionFormat="multi",
     *                    @OA\Items(type="string", example="The model field is required.")
     *                  ),
     *                  @OA\Property(property="nomor_plat", type="array", collectionFormat="multi",
     *                    @OA\Items(type="string", example="The nomor plat field is required.")
     *                  ),
     *                  @OA\Property(property="tarif_sewa_per_hari", type="array", collectionFormat="multi",
     *                    @OA\Items(type="string", example="The tarif sewa per hari field is required.")
     *                  ),
     *                  @OA\Property(property="ketersediaan", type="array", collectionFormat="multi",
     *                    @OA\Items(type="string", example="The ketersediaan field is required.")
     *                  )
     *              ),
     *          )
     *      )
     * )
     */

    public function edit(Request $request, $id)
    {
        $mobil = Mobil::find($id);

        if(!$mobil) {
            return $this->notFound('Mobil Tidak Ditemukan !');
        }

        $validator = Validator::make($request->all(), [
            'merek' => 'required|string',
            'model' => 'required|string',
            'nomor_plat' => 'required|string',
            'tarif_sewa_per_hari' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'ketersediaan' => 'required|boolean'
        ]);

        if($validator->fails()) {
            return $this->validationFailed($validator->errors());
        }

        $mobil->update([
            'merek' => $request->merek,
            'model' => $request->model,
            'nomor_plat' => $request->nomor_plat,
            'tarif_sewa_per_hari' => $request->tarif_sewa_per_hari,
            'ketersediaan' => $request->ketersediaan
        ]);

        return $this->success('Data Mobil Berhasil Diubah.');
    }

    /**
     * Delete a Mobil
     * @OA\Delete(
     *     path="/api/mobils/{id}",
     *     tags={"Mobil"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of Mobil to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Mobil deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Data Mobil Berhasil Dihapus !")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Mobil not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=404),
     *             @OA\Property(property="message", type="string", example="Data Mobil Tidak Ditemukan !")
     *         )
     *     )
     * )
     */

    public function delete($id) 
    {
        $mobil = Mobil::find($id);

        if(!$mobil) {
            return $this->notFound('Data Mobil Tidak Ditemukan !');
        }
        
        $mobil->delete();

        return $this->success('Data Mobil Berhasil Dihapus !');
    }
}
