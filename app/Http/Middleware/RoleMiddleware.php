<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $deniedRoles = array_filter($roles, fn($role) => str_starts_with($role, '!'));
        $allowedRoles = array_filter($roles, fn($role) => !str_starts_with($role, '!'));

        foreach ($deniedRoles as $denied) {
            $role = ltrim($denied, '!');
            if ($user->role === $role) {
                return response()->json(['message' => 'Forbidden. You do not have access.'], 403);
            }
        }

        if (!empty($allowedRoles) && !in_array($user->role, $allowedRoles)) {
            return response()->json(['message' => 'Forbidden. You do not have access.'], 403);
        }

        return $next($request);
    }
}
