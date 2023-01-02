<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreUserRequest;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\SuccessResponse;
use App\Models\User;

class UserController extends Controller
{
    public function create(StoreUserRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            return new ErrorResponse('User email already exists', [], 409);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return new SuccessResponse('Created successfully!', $user, 201);
    }
}
