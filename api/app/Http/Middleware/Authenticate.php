<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    // /**
    //  * Get the path the user should be redirected to when they are not authenticated.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return string|null
    //  */
    // protected function redirectTo($request)
    // {
    //     // if (! $request->expectsJson()) {
    //     //     return url(env('SPA_URL') . '/');
    //     // }

    //     if (!$request->expectsJson()) {
    //         abort(response()->json(['message' => 'Unauthenticated.'], 401));
    //     }
    // }

    public function authenticate($request, array $guards)
    {
        \Log::info('Auth Check', [
            'user' => auth()->user(),
            'session' => session()->all(),
            'cookies' => $request->cookies->all(), // Log cookies
            'headers' => $request->headers->all(),
        ]);

        return parent::authenticate($request, $guards);
    }
}
