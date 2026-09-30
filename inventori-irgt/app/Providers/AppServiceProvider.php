<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
        Paginator::defaultView('partials.pagination');
        Paginator::defaultSimpleView('partials.pagination');

        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $pendingReportsCount = 0;
            if (auth()->check() && in_array(auth()->user()->role, [\App\Models\User::ROLE_SUPER_ADMIN, \App\Models\User::ROLE_ADMIN], true)) {
                try {
                    $pendingReportsCount = \App\Models\MaintenanceReport::where('status', \App\Models\MaintenanceReport::STATUS_PENDING)->count();
                } catch (\Throwable $e) {
                    $pendingReportsCount = 0;
                }
            }
            $view->with('pendingReportsCount', $pendingReportsCount);
        });
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): Password => Password::min(8));
    }
}
