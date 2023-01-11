<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Admin\Ajax\CreateUpdateBlacklistRequest;
use App\Http\Resources\Admin\BlacklistResource;
use Domain\Users\Actions\CreateOrUpdateBlacklistAction;

class BlacklistController extends BaseAdminController
{
    /**
     * @param \App\Http\Requests\Admin\Ajax\CreateUpdateBlacklistRequest $request
     * @param \Domain\Users\Actions\CreateOrUpdateBlacklistAction $createOrUpdateAction
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function store(CreateUpdateBlacklistRequest $request, CreateOrUpdateBlacklistAction $createOrUpdateAction)
    {
        $entity = $createOrUpdateAction->execute($request->prepare());

        return new BlacklistResource($entity);
    }

    /**
     * @param \App\Http\Requests\Admin\Ajax\CreateUpdateBlacklistRequest $request
     * @param \Domain\Users\Actions\CreateOrUpdateBlacklistAction $createOrUpdateAction
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function update(CreateUpdateBlacklistRequest $request, CreateOrUpdateBlacklistAction $createOrUpdateAction)
    {
        /** @var \Domain\Users\Models\Blacklist $target */
        $target = $request->admin_blacklist;

        $entity = $createOrUpdateAction->execute($request->prepare(), $target);

        return new BlacklistResource($entity);
    }
}
