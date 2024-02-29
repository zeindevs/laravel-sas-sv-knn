<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

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
        // config(['app.locale' => 'id']);
        // Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        DB::listen(function ($query) {
            Log::info(
                $query->sql,
                [
                    'binding' => $query->bindings,
                    'time' => $query->time,
                ]
            );
        });

        Paginator::useBootstrapFive();
    }
}
