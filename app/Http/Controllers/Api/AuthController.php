<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Helpers\CookieHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\LogoutRequest;
use App\Http\Requests\Api\Auth\RefreshTokenRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Resources\Api\Auth\MeResource;
use App\Http\Resources\Api\Auth\TokensResource;
use App\Services\Auth\AuthServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

final class AuthController extends Controller
{
    public function __construct(
        private readonly AuthServiceContract $auth,
    ) {}

    public function me(Request $request): MeResource
    {
        return new MeResource($request->user());
    }

    public function logout(LogoutRequest $request): Response
    {
        $this->auth->logout($request->getRefreshToken());
        Auth::guard('api')->logout();

        return response()->noContent();
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->getDto();
        $tokens = $this->auth->login($data);

        $cookie = CookieHelper::setRefreshToken($tokens->refresh);

        return (new TokensResource($tokens))
            ->response()
            ->withCookie($cookie);
    }

    public function register(RegisterRequest $request): Response
    {
        $data = $request->getDto();
        $this->auth->register($data);

        return response()->noContent();
    }

    public function refresh(RefreshTokenRequest $request): JsonResponse
    {
        $data = $request->getDto();
        $tokens = $this->auth->refresh($data->refresh_token, $data->fingerprint);

        $cookie = CookieHelper::setRefreshToken($tokens->refresh);

        return (new TokensResource($tokens))
            ->response()
            ->withCookie($cookie);
    }
}
