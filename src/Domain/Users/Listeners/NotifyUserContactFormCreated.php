<?php

namespace Domain\Users\Listeners;

use App\Mail\ContactFormCreatedUserMail;
use Domain\Users\Events\ContactFormCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class NotifyUserContactFormCreated implements ShouldQueue
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
        Mail::to($event->contactForm->email)
            ->send(new ContactFormCreatedUserMail(
                $event->contactForm
            ));
    }
}
