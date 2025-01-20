<?php

namespace App\Http\Controllers;


use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Success\SuccessResource;
use App\Http\Resources\User\UserResource;
use App\Services\Auth\AuthService;
use Exception;

class AuthController extends Controller
{

    /**
     * @param RegisterRequest $request
     * @param AuthService $service
     * @return SuccessResource
     * @throws Exception
     */
    public function register(
        RegisterRequest $request,
        AuthService     $service
    ): SuccessResource
    {
        $service->register($request->getUserPassword(), $request->getUserEmail());

        return new SuccessResource([true]);
    }

    /**
     * @param LoginRequest $request
     * @param AuthService $service
     * @return UserResource
     * @throws Exception
     */
    public function login(
        LoginRequest $request,
        AuthService  $service
    ): UserResource {
        $response = $service->login($request->getUserPassword(), $request->getUserEmail());

        return new UserResource($response);
    }
}
