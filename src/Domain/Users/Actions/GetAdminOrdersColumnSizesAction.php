<?php

namespace Domain\Users\Actions;

use Domain\Common\Actions\BaseAction;
use Domain\Common\Enums\Column;
use Domain\Orders\Actions\GetDefaultAdminOrderColumnsAction;

class GetAdminOrdersColumnSizesAction extends BaseAction
{
    /**
     * @phpstan-return array<int, string>
     */
    public function execute(): array
    {
        return collect(
            GetDefaultAdminOrderColumnsAction::cached()->execute()
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