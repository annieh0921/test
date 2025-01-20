<?php

namespace App\Http\Requests\Auth;

class RegisterRequest extends AuthRequest
{
    public function rules(): array
    {
        return [
            self::EMAIL => 'required|email|unique:users,email',
        ];
    }

    public function getUserEmail(): string
    {
        return $this->input(self::EMAIL);
    }

    public function messages(): array
    {
        return [self::EMAIL => 'Incorrect data, please try again.'];
    }
}
