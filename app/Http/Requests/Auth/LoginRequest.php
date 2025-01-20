<?php

namespace App\Http\Requests\Auth;

class LoginRequest extends AuthRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [

            self::EMAIL => 'required|email|exists:users,email',
        ]);
    }

    public function messages(): array
    {
        return [self::EMAIL => 'Incorrect data, please try again.'];
    }
}
