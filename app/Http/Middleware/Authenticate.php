<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
{
    if (! $request->expectsJson()) {

        // admin route руу орж байвал
        if ($request->is('admin/*')) {
            return route('admin.login');
        }

        // user route
        return route('users.login');
    }

    return null;
}
}
