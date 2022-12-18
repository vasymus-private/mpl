<?php

namespace Domain\FAQs\Actions;

use Domain\Common\Actions\BaseAction;
use Domain\FAQs\Models\FAQ;
use Illuminate\Support\Facades\DB;

class DeleteFaqAction extends BaseAction
{
    /**
     * @param \Domain\FAQs\Models\FAQ $faq
     *
     * @return void
     */
    public function execute(FAQ $faq): void
    {
        DB::transaction(function () use ($faq) {
            $faq->children()->get()->each(function (FAQ $f) {
                $f->parent_id = null;
                $f->save();
            });

            $faq->delete();
        });
    }
}
