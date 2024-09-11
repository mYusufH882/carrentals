<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *    title="My Cool API",
 *    description="An API of cool stuffs",
 *    version="1.0.0",
 * ),
 * * @OA\SecurityScheme(
 *     type="apiKey",
 *     in="header",
 *     securityScheme="token",
 *     name="Authorization"
 * )
 */

abstract class Controller
{
    //
}
