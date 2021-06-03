<?php

namespace Domain\Products\DTOs;

use Domain\Products\Models\Category;
use Spatie\DataTransferObject\DataTransferObject;

class CategoryItemAdminDTO extends DataTransferObject
{
    public int $id;

    public ?string $name;

    /**
     * @var int|string
     */
    public $ordering = Category::ORDERING_DEFAULT;

    public bool $is_active = false;

    public ?string $is_active_name;

    public bool $is_checked = false;

    public static function fromModel(Category $category): self
    {
        return new self([
            'id' => $category->id,
            'name' => $category->name,
            'ordering' => $category->ordering ?? Category::ORDERING_DEFAULT,
            'is_active' => $category->is_active ?? false,
            'is_active_name' => (($category->is_active ?? false) ? 'Да' : 'Нет'),
        ]);
    }
}
