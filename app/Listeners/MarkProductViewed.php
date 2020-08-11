<?php

namespace App\Listeners;

use App\Events\ProductViewedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MarkProductViewed
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ProductViewedEvent $event
     * @return void
     */
    public function handle(ProductViewedEvent $event)
    {
        $event->user->viewed()->detach($event->product->id);
        $event->user->viewed()->syncWithoutDetaching($event->product->id);
    }
}
