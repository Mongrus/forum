<?php

namespace App\Http\Middleware;

use App\enum\UserStatus;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsModeratorOrAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (
            ! $user ||
            ! in_array($user->status, [UserStatus::ADMIN, UserStatus::MODERATOR], true)
        ) {
            abort(403, 'У вас нет прав доступа к административной странице!');
        }

        return $next($request);
    }
}
