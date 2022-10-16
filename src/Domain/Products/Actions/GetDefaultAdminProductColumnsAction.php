<?php

namespace Domain\Products\Actions;

use Domain\Common\Actions\BaseAction;
use Domain\Common\Enums\Column;

class GetDefaultAdminProductColumnsAction extends BaseAction
{
    /**
     * @return \Domain\Common\Enums\Column[]
     */
    public function execute(): array
    {
        return [
            Column::ordering(),
            Column::name(),
            Column::active(),
            Column::unit(),
            Column::price_purchase(),
            Column::price_retail(),
            Column::admin_comment(),
            Column::availability(),
            Column::id(),
            Column::categories(),
        ];
    }
}
