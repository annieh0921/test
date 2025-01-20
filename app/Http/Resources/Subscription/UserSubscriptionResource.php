<?php

namespace App\Http\Resources\Subscription;

use Illuminate\Http\Resources\Json\JsonResource;

class UserSubscriptionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'start_at' => $this->resource->start_at,
            'expired_at' => $this->resource->expired_at,
            'status' => $this->resource->status,
            'subscription' => new SubscriptionResource($this->whenLoaded('subscription')),
        ];
    }
}
