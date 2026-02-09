<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Event;
use App\Models\Payment;
use App\Observers\EventObserver;
use App\Observers\PaymentObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Services\TicketService::class, function ($app) {
            return new \App\Services\TicketService();
        });
        
        $this->app->bind(\App\Services\NotificationService::class, function ($app) {
            return new \App\Services\NotificationService();
        });

        $this->app->bind(\App\Services\CalendarService::class, function ($app) {
            return new \App\Services\CalendarService();
        });

        $this->app->bind(\App\Services\MapService::class, function ($app) {
            return new \App\Services\MapService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register model observers
        Event::observe(EventObserver::class);
        Payment::observe(PaymentObserver::class);
        
        // Add global helper for dashboard routing
        \Blade::directive('dashboardRoute', function () {
            return "<?php echo auth()->user()->role === 'admin' || auth()->user()->role === 'super_admin' ? route('admin.dashboard') : route('user.dashboard'); ?>";
        });
    }
}
