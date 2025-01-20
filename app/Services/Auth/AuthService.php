<?php

namespace App\Services\Auth;

use App\Models\User;
use Exception;

class AuthService
{
    /*** @throws Exception */
    public function register(string $password, string $email): void
    {
        try {
            $user = User::createUser($password, $email);
            $user->save();
        }catch (Exception $e){
            throw new Exception('User Registration Failed');
        }

    }

    /*** @throws Exception */
    public function login(string $password, string $email): User
    {
        $user = User::query()->where('email', $email)->first();
        /** @var User $user */
        if (!$user || !$user->checkPassword($password)) {
            throw new Exception('Incorrect data');
        }

        $user->token =  $user->createToken('api_token')->plainTextToken;

        return $user;
    }
}
