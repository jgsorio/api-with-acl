<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(
        protected UserRepository $userRepository
    ) {}

    public function login(LoginRequest $request)
    {
        if (!auth()->attempt($request->validated())) {
            return response()->json(['error' => 'credentials does not match'], Response::HTTP_UNAUTHORIZED);
        }

        $token = auth()->user()->createToken('acl_api')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function me()
    {
        $user = auth()->user();
        return new UserResource($user);
    }
}
