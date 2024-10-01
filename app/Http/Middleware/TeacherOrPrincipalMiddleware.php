<?php

namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TeacherOrPrincipalMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // abort if the user is not a teacher or principal
        abort_unless(auth()->user()->role_id === RoleEnum::TEACHER || auth()->user()->role_id === RoleEnum::PRINCIPAL, 403);

        return $next($request);
    }
}
