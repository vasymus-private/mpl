<?php

namespace Domain\Products\DTOs;

use Domain\Products\Models\Category;
use Spatie\DataTransferObject\DataTransferObject;

class FiltrateByCategoriesParamsDTO extends DataTransferObject
{
    /**
     * @var \Domain\Products\Models\Category|null
     */
    public ?Category $category;

    /**
     * @var \Domain\Products\Models\Category|null
     */
    public ?Category $subcategory1;

    /**
     * @var \Domain\Products\Models\Category|null
     */
    public ?Category $subcategory2;

    /**
     * @var \Domain\Products\Models\Category|null
     */
    public ?Category $subcategory3;
}
