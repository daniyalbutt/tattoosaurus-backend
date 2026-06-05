<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\User;
use App\Models\Testimonial;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Admin sidebar — pending artist count
        View::composer('admin.partials.sidebar', function ($view) {
            $view->with('pendingCount',
                User::role('artist')->where('status', 'pending')->count()
            );
        });

        // Front-end — active testimonials (shared to all front views)
        View::composer('components.testimonials', function ($view) {
            $view->with('testimonials', Testimonial::active()->get());
        });
    }
}