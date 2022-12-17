<?php

namespace Domain\FAQs\Actions;

use Domain\Common\Actions\BaseAction;
use Domain\FAQs\DTOs\FaqDTO;
use Domain\FAQs\Models\FAQ;

class CreateOrUpdateFaqAction extends BaseAction
{
    /**
     * @param \Domain\FAQs\DTOs\FaqDTO $faqDTO
     * @param \Domain\FAQs\Models\FAQ|null $target
     *
     * @return \Domain\FAQs\Models\FAQ
     */
    public function execute(FaqDTO $faqDTO, FAQ $target = null): FAQ
    {
        return new FAQ(); // todo
    }
}
