<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Admin\Ajax\FaqBulkDeleteRequest;
use App\Http\Requests\Admin\Ajax\FaqBulkUpdateRequest;
use App\Http\Resources\Admin\FaqItemResource;
use Domain\FAQs\Actions\DeleteFaqAction;
use Domain\FAQs\Models\FAQ;
use Symfony\Component\HttpFoundation\Response;

class FaqBulkController extends BaseAdminController
{
    /**
     * @param \App\Http\Requests\Admin\Ajax\FaqBulkUpdateRequest $request
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function update(FaqBulkUpdateRequest $request)
    {
        $payload = $request->payload();
        $ids = collect($payload)->pluck('id')->toArray();

        $categoriesToUpdate = FAQ::query()
            ->whereIn('id', $ids)
            ->get();

        $categoriesToUpdate->each(function (FAQ $faq) use ($payload) {
            $toUpdate = $payload[$faq->id];
            $faq->forceFill(
                collect($toUpdate->all())
                    ->except(['id'])
                    ->all()
            );
            $faq->save();
        });

        return FaqItemResource::collection(
            FAQ::query()
                ->whereIn('id', $ids)
                ->get()
        );
    }

    /**
     * @param \App\Http\Requests\Admin\Ajax\FaqBulkDeleteRequest $request
     * @param \Domain\FAQs\Actions\DeleteFaqAction $deleteFaqAction
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(FaqBulkDeleteRequest $request, DeleteFaqAction $deleteFaqAction)
    {
        $items = FAQ::query()->whereIn(sprintf('%s.id', FAQ::TABLE), $request->ids)->get();

        $items->each(function (FAQ $item) use ($deleteFaqAction) {
            $deleteFaqAction->execute($item);
        });

        return response('', Response::HTTP_NO_CONTENT);
    }
}
