<?php

namespace Domain\Products\Actions;

use Domain\Common\Actions\BaseAction;
use Domain\Common\Enums\Column;

class GetDefaultAdminProductVariantColumnsAction extends BaseAction
{
    /**
     * @return \Domain\Common\Enums\Column[]
     */
    public function execute(): array
    {
        return [
            Column::name(),
            Column::active(),
            Column::detailed_image(),
            Column::additional_images(),
            Column::ordering(),
            Column::price_purchase(),
            Column::unit(),
            Column::coefficient(),
            Column::coefficient_description(),
            Column::price_retail(),
            Column::availability(),
            Column::id(),
        ];
    }
}
