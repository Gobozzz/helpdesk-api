<?php

declare(strict_types=1);

namespace App\Helpers;

use Symfony\Component\HttpFoundation\Cookie;

final class CookieHelper
{
    const REFRESH_TOKEN_COOKIE = 'refresh_token';

    public static function setRefreshToken(
        string $refreshToken,
    ): Cookie
    {

        return cookie(
            name: self::REFRESH_TOKEN_COOKIE,
            value: $refreshToken,
            minutes: config('jwt.refresh_ttl'),
            path: '/',
            domain: null,
            secure: config('app.env') === 'production',
            httpOnly: true,
            raw: false,
            sameSite: 'strict'
        );
    }
    

}
