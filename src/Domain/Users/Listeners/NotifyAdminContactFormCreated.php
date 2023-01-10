<?php

namespace Domain\Users\Listeners;

use App\Mail\ContactFormCreatedAdminMail;
use Domain\Users\Events\ContactFormCreatedEvent;
use Domain\Users\Models\Admin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class NotifyAdminContactFormCreated implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param \Domain\Users\Events\ContactFormCreatedEvent $event
     *
     * @return void
     */
    public function handle(ContactFormCreatedEvent $event)
    {
        $centralAdminEmail = Admin::getCentralAdmin()->email;

        Mail::to($centralAdminEmail)
            ->send(
                new ContactFormCreatedAdminMail(
                    $event->contactForm,
                    $centralAdminEmail
                )
            );
    }
}
