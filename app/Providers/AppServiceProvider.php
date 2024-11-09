<?php

namespace App\Providers;

use App\Policies\CategoryPolicy;
use App\Policies\TodoPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Vite;
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
        Vite::prefetch(concurrency: 3);

        Gate::define('delete-todo', [TodoPolicy::class, 'delete']);
        Gate::define('update-todo', [TodoPolicy::class, 'update']);
        // ------
        Gate::define('delete-category', [CategoryPolicy::class, 'delete']);
        Gate::define('update-category', [CategoryPolicy::class, 'update']);
    }
}
