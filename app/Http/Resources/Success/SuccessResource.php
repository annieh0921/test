<?php

namespace App\Http\Resources\Success;

use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SuccessResource extends JsonResource
{
    public function withResponse($request, $response): void
    {
        $response->setStatusCode($this->resource[1] ?? ResponseAlias::HTTP_OK);
    }

    public function toArray($request): array
    {
        return [
            'success' => $this->resource[0] ?? false,
        ];
    }
}
