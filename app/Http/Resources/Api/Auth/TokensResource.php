<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\Auth;

use App\DTO\JWT\GeneratedTokensDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class TokensResource extends JsonResource
{

    public function __construct(GeneratedTokensDTO $resource)
    {
        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {
        return [
            'access_token' => $this->resource->access,
            'refresh_token' => $this->resource->refresh,
            'type' => config('jwt.token_type'),
            'expire_in_access' => config('jwt.ttl') * 60,
            'expire_in_refresh' => config('jwt.refresh_ttl') * 60,
        ];
    }
}
