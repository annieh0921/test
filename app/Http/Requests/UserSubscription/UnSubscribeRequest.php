<?php

namespace App\Http\Requests\UserSubscription;

use Illuminate\Foundation\Http\FormRequest;

class UnSubscribeRequest extends FormRequest
{
    private const SUBSCRIPTION_ID = 'subscription_id';

    public function rules(): array
    {
        return [
            self::SUBSCRIPTION_ID => [
                'required',
                'integer',
                'exists:subscriptions,id'
            ]
        ];

    }
    public function getSubscriptionId(): int
    {
        return $this->input(self::SUBSCRIPTION_ID);
    }
}
