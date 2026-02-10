<?php

namespace App\Providers;

use App\Repositories\Section\SectionRepository;
use App\Repositories\Section\SectionRepositoryInterface;
use App\Services\Section\SectionService;
use App\Services\Section\SectionServiceInterface;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            SectionRepositoryInterface::class,
            SectionRepository::class
        );

        $this->app->bind(
            SectionServiceInterface::class,
            SectionService::class
        );
    }

    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);

        RateLimiter::for('chat', function ($request) {
            return Limit::perMinute(30)
            ->by($request->user()->id)
            ->response(function () {
                return back()->withErrors([
                'error' => 'Слишком много сообщений. Подождите немного.'
            ]);
            });
        });
    }
}
