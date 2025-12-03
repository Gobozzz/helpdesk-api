<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Auth\AuthenticationException;

trait HasRefreshTokenRequest
{
    /*
     * В первую очередь пытаемся получить refresh токен с куки, если там нет, то берем с тела запроса.
     */
    public function getRefreshToken(): string
    {
        $token = request()->cookie('refresh_token') ?? request()->get('refresh_token');
        if (!is_string($token)) {
            throw new AuthenticationException('Refresh token missing.');
        }
        return $token;
    }
}
