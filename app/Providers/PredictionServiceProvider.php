<?php

namespace App\Providers;

use App\Services\Impl\PredictionServiceImpl;
use App\Services\PredictionService;
use Illuminate\Support\ServiceProvider;

class PredictionServiceProvider extends ServiceProvider
{
    public array $singletons = [
        PredictionService::class => PredictionServiceImpl::class
    ];

    public function provides(): array
    {
        return [];
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
