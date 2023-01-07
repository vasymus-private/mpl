<?php

namespace Domain\Users\Actions;

use Domain\Common\Actions\BaseAction;
use Domain\Common\Enums\Column;
use Domain\Products\Actions\GetDefaultAdminProductVariantColumnsAction;

class GetAdminProductVariationsTableDefaultSizesAction extends BaseAction
{
    /**
     * @phpstan-return array<int, string>
     */
    public function execute(): array
    {
        return collect(
            GetDefaultAdminProductVariantColumnsAction::cached()->execute()
        )
            ->reduce(
                function (array $acc, Column $column): array {
                    $acc[$column->value] = 'auto';

                    return $acc;
                },
                []
            );
    }
}
