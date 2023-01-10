<?php

namespace Domain\Users\Actions;

use Domain\Common\Actions\BaseAction;
use Domain\GalleryItems\Models\GalleryItem;
use Domain\Users\DTOs\BlacklistDTO;
use Domain\Users\Models\Blacklist;
use Illuminate\Support\Facades\DB;

class CreateOrUpdateBlacklistAction extends BaseAction
{
    /**
     * @param \Domain\Users\DTOs\BlacklistDTO $dto
     * @param \Domain\Users\Models\Blacklist|null $target
     *
     * @return \Domain\GalleryItems\Models\GalleryItem
     */
    public function execute(BlacklistDTO $dto, Blacklist $target = null): GalleryItem
    {
        return DB::transaction(function () use ($dto, $target) {
            $target = $target ?: new Blacklist();

            if ($dto->ip !== null) {
                $target->ip = $dto->ip;
            }

            if ($dto->email !== null) {
                $target->email = $dto->email;
            }

            $target->save();

            return $target;
        });
    }
}
