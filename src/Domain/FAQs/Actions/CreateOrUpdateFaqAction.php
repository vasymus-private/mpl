<?php

namespace Domain\FAQs\Actions;

use Domain\Common\Actions\BaseAction;
use Domain\Common\Actions\SaveSeoAction;
use Domain\FAQs\DTOs\FaqDTO;
use Domain\FAQs\Models\FAQ;
use Illuminate\Support\Facades\DB;

class CreateOrUpdateFaqAction extends BaseAction
{
    /**
     * @var \Domain\Common\Actions\SaveSeoAction
     */
    private SaveSeoAction $saveSeoAction;

    /**
     * @param \Domain\Common\Actions\SaveSeoAction $saveSeoAction
     */
    public function __construct(SaveSeoAction $saveSeoAction)
    {
        $this->saveSeoAction = $saveSeoAction;
    }

    /**
     * @param \Domain\FAQs\DTOs\FaqDTO $faqDTO
     * @param \Domain\FAQs\Models\FAQ|null $target
     *
     * @return \Domain\FAQs\Models\FAQ
     */
    public function execute(FaqDTO $faqDTO, FAQ $target = null): FAQ
    {
        return DB::transaction(function () use ($faqDTO, $target) {
            $target = $target ?: new FAQ();

            if ($faqDTO->name !== null) {
                $target->name = $faqDTO->name;
            }

            if ($faqDTO->slug !== null) {
                $target->slug = $faqDTO->slug;
            }

            if ($faqDTO->is_active !== null) {
                $target->is_active = $faqDTO->is_active;
            }

            /** @see \Domain\FAQs\Models\FAQ::$parent_id */
            $target->setNullableForeignInt('parent_id', $faqDTO->parent_id);

            if ($faqDTO->question !== null) {
                $target->question = $faqDTO->question;
            }

            if ($faqDTO->answer !== null) {
                $target->answer = $faqDTO->answer;
            }

            if (! $target->id) {
                $target->save();
            }

            $this->saveSeoAction->execute($target, $faqDTO->seo);

            $target->save();

            return $target;
        });
    }
}
