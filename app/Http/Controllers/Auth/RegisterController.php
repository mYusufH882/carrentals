<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:8|confirmed',
            'alamat'    => 'required|string',
            'no_telepon' => 'required|numeric',
            'no_sim'    => 'required|numeric',
            'role'      => 'required' 
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
            'alamat'    => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'no_sim'    => $request->no_sim,
            'role'      => $request->role,
        ]);

        if($user) {
            return response()->json([
                'success' => 201,
                'data'    => $user,  
            ], 201);
        }

        return response()->json([
            'success' => false,
        ], 409);
    }
}
