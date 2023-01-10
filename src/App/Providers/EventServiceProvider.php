<?php

namespace App\Providers;

use Domain\Products\Events\ProductViewedEvent;
use Domain\Products\Listeners\MarkProductViewed;
use Domain\Services\Events\ServiceViewedEvent;
use Domain\Services\Listeners\MarkServiceViewed;
use Domain\Users\Events\ContactFormCreatedEvent;
use Domain\Users\Listeners\NotifyAdminContactFormCreated;
use Domain\Users\Listeners\NotifyUserContactFormCreated;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ProductViewedEvent::class => [
            MarkProductViewed::class,
        ],
        ServiceViewedEvent::class => [
            MarkServiceViewed::class,
        ],
        ContactFormCreatedEvent::class => [
            NotifyAdminContactFormCreated::class,
            NotifyUserContactFormCreated::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
