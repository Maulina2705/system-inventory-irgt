<?php

namespace App\Http\Middleware;

use App\Models\SystemSetting;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRecoveryMode
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. If recovery mode is not active, allow normal flow
        if (!SystemSetting::isRecoveryMode()) {
            return $next($request);
        }

        // 2. Allow logged-in Super Admin AND Admin to access the entire system without interruption
        $user = $request->user();
        if ($user && in_array($user->role, [User::ROLE_SUPER_ADMIN, User::ROLE_ADMIN], true)) {
            return $next($request);
        }

        // 3. Allow authentication and system recovery toggle/preview routes
        $allowedRoutes = [
            'login',
            'login.store',
            'logout',
            'password.request',
            'password.email',
            'password.reset',
            'password.update',
            'two-factor.login',
            'two-factor.login.store',
            'system-recovery.toggle',
            'system-recovery.preview',
        ];

        foreach ($allowedRoutes as $route) {
            if ($request->routeIs($route)) {
                return $next($request);
            }
        }

        // Also allow static assets like images, css, js, fonts
        if ($request->is('images/*') || $request->is('css/*') || $request->is('js/*') || $request->is('flux/*') || $request->is('fonts/*') || $request->is('storage/*')) {
            return $next($request);
        }

        // 4. Render the recovery mode maintenance page for public & non-admin users
        $details = SystemSetting::getRecoveryDetails();

        return response()->view('maintenance', [
            'title' => $details['title'],
            'message' => $details['message'],
            'estimated_end' => $details['estimated_end'],
            'activated_by' => $details['activated_by'],
        ], 503);
    }
}
