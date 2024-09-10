<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Register
     * @OA\Post (
     *     path="/api/register",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(property="name", type="string"),
     *                      @OA\Property(property="email", type="string"),
     *                      @OA\Property(property="password", type="string"),
     *                      @OA\Property(property="password_confirmation", type="string"),
     *                      @OA\Property(property="alamat", type="string"),
     *                      @OA\Property(property="no_telepon", type="number"),
     *                      @OA\Property(property="no_sim", type="number"),
     *                      @OA\Property(property="role", type="string")
     *                 ),
     *                 example={
     *                     "name":"John",
     *                     "email":"john@test.com",
     *                     "password":"johnjohn1",
     *                     "password_confirmation":"johnjohn1",
     *                     "alamat":"Jl. Contoh No. 1",
     *                     "no_telepon": "08123456789",
     *                     "no_sim": "123456789",
     *                     "role":"customer"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Registration successful",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="id", type="number", example=1),
     *                  @OA\Property(property="name", type="string", example="John"),
     *                  @OA\Property(property="email", type="string", example="john@test.com"),
     *                  @OA\Property(property="alamat", type="string", example="Jl. Contoh No. 1"),
     *                  @OA\Property(property="no_telepon", type="number", example=08123456789),
     *                  @OA\Property(property="no_sim", type="number", example=123456789),
     *                  @OA\Property(property="role", type="string", example="customer"),
     *                  @OA\Property(property="created_at", type="string", example="2022-06-28 06:06:17"),
     *                  @OA\Property(property="updated_at", type="string", example="2022-06-28 06:06:17"),
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="errors", type="object",
     *                  @OA\Property(property="email", type="array", collectionFormat="multi",
     *                    @OA\Items(
     *                      type="string",
     *                      example="The email has already been taken."
     *                    )
     *                  ),
     *                  @OA\Property(property="password", type="array", collectionFormat="multi",
     *                    @OA\Items(
     *                      type="string",
     *                      example="The password must be at least 8 characters."
     *                    )
     *                  ),
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=409,
     *          description="Conflict",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="User could not be created.")
     *          )
     *      )
     * )
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
