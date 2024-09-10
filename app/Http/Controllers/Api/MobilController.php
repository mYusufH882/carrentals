<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mobil;
use App\Traits\ResponseApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MobilController extends Controller
{
    use ResponseApi;

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
