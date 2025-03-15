<?php

namespace App\Http\Middleware;

use Inertia\Inertia;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        Log::info('AdminMiddleware triggered.');

        if (!Auth::check()) {
            Log::warning('User not authenticated, redirecting to login.');
            return redirect()->route('login');
        }

        Log::info('User authenticated: ' . Auth::user()->email);

        if (Auth::user()->role_id <= 0) {
            Log::warning('User does not have admin access, redirecting.');
            return redirect('/')->with('error', 'Unauthorized access');
        }

        return $next($request);
    }
}