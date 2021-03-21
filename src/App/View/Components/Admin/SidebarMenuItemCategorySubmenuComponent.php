<?php

namespace App\View\Components\Admin;

use Domain\Products\Models\Category;
use Illuminate\View\Component;

class SidebarMenuItemCategorySubmenuComponent extends Component
{
    protected ?Category $category;

    /**
     * @param \Domain\Products\Models\Category|null $category
     */
    public function __construct(Category $category = null)
    {
        $this->category = $category;
    }

    public function id(): string
    {
        return $this->category ? "products-level-{$this->category->id}" : "products-level";
    }

    public function isActive(): bool
    {
        return false;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('admin.components.sidebar-menu-item-category-submenu-component');
    }
}
