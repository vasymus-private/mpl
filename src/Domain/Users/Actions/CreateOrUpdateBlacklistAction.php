<?php

namespace Domain\Users\Actions;

use Domain\Common\Actions\BaseAction;
use Domain\Ip\Actions\GetIpAction;
use Domain\Users\DTOs\BlacklistDTO;
use Domain\Users\Models\Blacklist;
use Illuminate\Support\Facades\DB;

class CreateOrUpdateBlacklistAction extends BaseAction
{
    public function __construct(private readonly GetIpAction $getIpAction)
    {
    }

    /**
     * @param \Domain\Users\DTOs\BlacklistDTO $dto
     * @param \Domain\Users\Models\Blacklist|null $target
     *
     * @return \Domain\Users\Models\Blacklist
     */
    public function execute(BlacklistDTO $dto, Blacklist $target = null): Blacklist
    {
        return DB::transaction(function () use ($dto, $target) {
            $target = $target ?: new Blacklist();

            if ($dto->email !== null) {
                $target->email = $dto->email;
            }

            if ($dto->ip !== null) {
                $ipModel = $this->getIpAction->execute($dto->ip);
                $target->ip = $ipModel ? $ipModel->ip : $dto->ip;
            }

            $target->save();

            return $target;
        });
    }
}
