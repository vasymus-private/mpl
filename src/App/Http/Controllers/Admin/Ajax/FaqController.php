<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Admin\Ajax\CreateUpdateFaqRequest;
use App\Http\Resources\Admin\FaqResource;
use Domain\FAQs\Actions\CreateOrUpdateFaqAction;

class FaqController extends BaseAdminController
{
    /**
     * @param \App\Http\Requests\Admin\Ajax\CreateUpdateFaqRequest $request
     * @param \Domain\FAQs\Actions\CreateOrUpdateFaqAction $createOrUpdateFaqAction
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function store(CreateUpdateFaqRequest $request, CreateOrUpdateFaqAction $createOrUpdateFaqAction)
    {
        $brand = $createOrUpdateFaqAction->execute($request->prepare());

        return new FaqResource($brand);
    }

    /**
     * @param \App\Http\Requests\Admin\Ajax\CreateUpdateFaqRequest $request
     * @param \Domain\FAQs\Actions\CreateOrUpdateFaqAction $createOrUpdateFaqAction
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function update(CreateUpdateFaqRequest $request, CreateOrUpdateFaqAction $createOrUpdateFaqAction)
    {
        /** @var \Domain\FAQs\Models\FAQ $target */
        $target = $request->admin_faq;

        $faq = $createOrUpdateFaqAction->execute($request->prepare(), $target);

        return new FaqResource($faq);
    }
}
