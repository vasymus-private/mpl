<?php

namespace App\Services\Breadcrumbs;

use Spatie\DataTransferObject\DataTransferObject;

class BreadcrumbDTO extends DataTransferObject
{
    /**
     * @var string
     * */
    public $name;

    /**
     * @var string|null
     * */
    public $url;
}
