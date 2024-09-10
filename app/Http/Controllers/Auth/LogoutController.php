<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ResponseApi;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutController extends Controller
{
    use ResponseApi;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

        if($removeToken) {
            return $this->success(null, 'Anda Telah Logout !');
        }
    }
}
