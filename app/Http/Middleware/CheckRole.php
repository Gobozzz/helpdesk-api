<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Actions\User\UserHasAnyRoleAction;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class CheckRole
{

    public function __construct(
        private UserHasAnyRoleAction $hasAnyRole,
    )
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if ($this->hasAnyRole->handle($user, $roles)) {
            return $next($request);
        }

        throw new AuthorizationException();
    }
}
