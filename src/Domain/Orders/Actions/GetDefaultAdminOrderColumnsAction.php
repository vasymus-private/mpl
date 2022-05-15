<?php

namespace Domain\Orders\Actions;

use Domain\Common\Actions\BaseAction;
use Domain\Common\Enums\Column;

class GetDefaultAdminOrderColumnsAction extends BaseAction
{
    /**
     * @return \Domain\Common\Enums\Column[]
     */
    public function execute(): array
    {
        return [
            Column::date_creation(),
            Column::id(),
            Column::status(),
            Column::positions(),
            Column::comment_admin(),
            Column::importance(),
            Column::manager(),
            Column::sum(),
            Column::name(),
            Column::phone(),
            Column::email(),
            Column::comment_user(),
            Column::payment_method(),
        ];
    }
}
