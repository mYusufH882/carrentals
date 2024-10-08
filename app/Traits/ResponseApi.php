<?php

namespace App\Traits;

trait ResponseApi
{
    public function successLogin($token, $name, $role, $message = 'Login successful', $status = 201)
    {
        return response()->json([
            'status' => $status,
            'name' => $name,
            'role' => $role,
            'token' => $token,
            'message' => $message,
        ], $status);
    }

    public function success($data, $message = 'Request successful', $status = 201)
    {
        return response()->json([
            'status' => $status,
            'data' => $data,
            'message' => $message,
        ], $status);
    }

    public function validationFailed($validator)
    {
        return response()->json([
            'status' => 422,
            'errors' => $validator->errors(),
            'message' => 'Validasi gagal, harap cek input Anda'
        ], 422);
    }

    public function notFound($message = 'Resource tidak ditemukan')
    {
        return response()->json([
            'status' => 404,
            'message' => $message,
        ], 404);
    }

    public function forbidden($message = 'Kamu tidak memiliki akses role ini.')
    {
        return response()->json([
            'status' => 403,
            'message' => $message,
        ], 403);
    }

    public function error($error, $message = 'Internal Server Error', $status = 500)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'error' => $error,
        ], 500);   
    }
}
