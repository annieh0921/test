<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    protected const PASSWORD = 'password';
    protected const EMAIL = 'email';

    public function rules(): array
    {
        return [
            self::PASSWORD => 'required|string|min:6',
        ];
    }

    public function getUserEmail(): string
    {
        return $this->input(self::EMAIL);
    }

    public function getUserPassword(): string
    {
        return $this->input(self::PASSWORD);
    }
}
