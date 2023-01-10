<?php

namespace Domain\Users\Events;

use Domain\Users\Models\ContactForm;

class ContactFormCreatedEvent
{
    public function __construct(public ContactForm $contactForm)
    {
    }
}
