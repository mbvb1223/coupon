<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\GenerateTokenRequest;
use App\Http\Requests\API\StoreUserRequest;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\SuccessResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @OA\Post(
     *     path="/users/create",
     *     summary="Create a new user",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={"name": "Khien", "email": "test@gmail.com", "password": "123456"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Examples(example="result", value={
                        "success": true,
                        "code": 201,
                        "message": "Created successfully!",
                        "data": {
                                "name": "Khien",
                                "email": "tes1t@gmail.comd",
                                "updated_at": "2023-01-02T17:34:33.000000Z",
                                "created_at": "2023-01-02T17:34:33.000000Z",
                                "id": 4
                            }
    }, summary="An result object."),
     *         )
     *     )
     * )
     */
    public function create(StoreUserRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            return new ErrorResponse('User email already exists', [], 409);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return new SuccessResponse('Created successfully!', $user, 201);
    }

    /**
     * @OA\Post(
     *     path="/users/token",
     *     summary="Generate a new token",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="device_name",
     *                     type="string"
     *                 ),
     *                 example={"email": "phamkhien@hotmail.com", "password": "123456", "device_name": "iphone 2000"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Examples(example="result", value= {
                    "success": true,
                    "code": 201,
                    "message": "Created successfully!",
                    "data": "2|B9tN94NEoV5sRsK1y59djIKHVSgDq0JkWwV3oiAP"
     }, summary="An result object."),
     *         )
     *     )
     * )
     */
    public function token(GenerateTokenRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return new ErrorResponse('The provided credentials are incorrect.', [], 400);
        }

        return new SuccessResponse('Created successfully!', $user->createToken($request->device_name)->plainTextToken, 201);
    }
}
