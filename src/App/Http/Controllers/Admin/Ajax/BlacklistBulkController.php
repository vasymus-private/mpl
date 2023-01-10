<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Admin\Ajax\BlacklistBulkDeleteRequest;
use App\Http\Requests\Admin\Ajax\BlacklistBulkUpdateRequest;
use App\Http\Resources\Admin\BlacklistItemResource;
use Domain\Users\Models\Blacklist;
use Symfony\Component\HttpFoundation\Response;

class BlacklistBulkController extends BaseAdminController
{
    /**
     * @param \App\Http\Requests\Admin\Ajax\BlacklistBulkUpdateRequest $request
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function update(BlacklistBulkUpdateRequest $request)
    {
        $payload = $request->payload();
        $ids = collect($payload)->pluck('id')->toArray();

        $categoriesToUpdate = Blacklist::query()
            ->whereIn('id', $ids)
            ->get();

        $categoriesToUpdate->each(function (Blacklist $item) use ($payload) {
            $toUpdate = $payload[$item->id];
            $item->forceFill(
                collect($toUpdate->all())
                    ->except(['id'])
                    ->all()
            );
            $item->save();
        });

        return BlacklistItemResource::collection(
            Blacklist::query()
                ->whereIn('id', $ids)
                ->get()
        );
    }

    /**
     * @param \App\Http\Requests\Admin\Ajax\BlacklistBulkDeleteRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(BlacklistBulkDeleteRequest $request)
    {
        $items = Blacklist::query()->whereIn(sprintf('%s.id', Blacklist::TABLE), $request->ids)->get();

        $items->each(function (Blacklist $item) {
            $item->delete();
        });

        return response('', Response::HTTP_NO_CONTENT);
    }
}
