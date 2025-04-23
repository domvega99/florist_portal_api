<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Fetch role name from roles table
        $roleName = DB::table('roles')->where('id', $user->role)->value('name');

        if (!$roleName) {
            return response()->json(['message' => 'Role not found'], 403);
        }

        $deniedRoles = array_filter($roles, fn($role) => str_starts_with($role, '!'));
        $allowedRoles = array_filter($roles, fn($role) => !str_starts_with($role, '!'));

        foreach ($deniedRoles as $denied) {
            $deniedName = ltrim($denied, '!');
            if ($roleName === $deniedName) {
                return response()->json(['message' => 'Forbidden. You do not have access.'], 403);
            }
        }

        if (!empty($allowedRoles) && !in_array($roleName, $allowedRoles)) {
            return response()->json(['message' => 'Forbidden. You do not have access.'], 403);
        }

        return $next($request);
    }
}
