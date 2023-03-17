<?php

namespace Domain\Users\Actions\ContactForm;

use Carbon\Carbon;
use Domain\Common\Actions\BaseAction;
use Domain\Users\Models\Admin;
use Domain\Users\Models\ContactForm;

class MarkReadAction extends BaseAction
{
    /**
     * @param \Domain\Users\Models\ContactForm $contactForm
     * @param \Domain\Users\Models\Admin $admin
     * @param \Carbon\Carbon $date
     *
     * @return \Domain\Users\Models\ContactForm
     */
    public function execute(ContactForm $contactForm, Admin $admin, Carbon $date): ContactForm
    {
        $contactForm->read_by_admin_id = $admin->id;
        $contactForm->read_by_admin_at = $date;

        $contactForm->save();

        return $contactForm;
    }
}
