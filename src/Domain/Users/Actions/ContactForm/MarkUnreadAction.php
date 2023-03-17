<?php

namespace Domain\Users\Actions\ContactForm;

use Domain\Common\Actions\BaseAction;
use Domain\Users\Models\ContactForm;

class MarkUnreadAction extends BaseAction
{
    /**
     * @param \Domain\Users\Models\ContactForm $contactForm
     *
     * @return \Domain\Users\Models\ContactForm
     */
    public function execute(ContactForm $contactForm): ContactForm
    {
        $contactForm->read_by_admin_id = null;
        $contactForm->read_by_admin_at = null;

        $contactForm->save();

        return $contactForm;
    }
}
