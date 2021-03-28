<?php

namespace App\View\Components\Admin;

use Domain\Products\Models\Category;

class SidebarMenuItemCategorySubmenuComponent extends BaseSidebarMenuItemCategoryComponent
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
        $baseIdHref = $this->getBaseIdHref();
        return $this->category ? "$baseIdHref-{$this->category->id}" : $baseIdHref;
    }

    public function isActive(): bool
    {
        return parent::isActive();
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
