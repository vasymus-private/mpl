<?php

namespace App\View\Components\Admin;

use Domain\Products\Models\Category;
use Illuminate\Support\HtmlString;
use Illuminate\View\Component;

class SidebarMenuItemCategoryCollapserComponent extends Component
{
    protected ?Category $category;

    /**
     * @param \Domain\Products\Models\Category|null $category
     */
    public function __construct(Category $category = null)
    {
        $this->category = $category;
    }

    public function text(): HtmlString
    {
        $text = $this->category
            ? $this->category->name
            : ("Каталог товаров" . ($this->isActive() ? ' <span class="sr-only">(current)</span>' : "") . '<i class="fa fa-shopping-cart" aria-hidden="true"></i>');

        return new HtmlString($text);
    }

    public function ariaExpanded(): string
    {
        return $this->isActive() ? "true" : "false";
    }

    public function ariaControls(): string
    {
        return $this->category ? "products-level-{$this->category->id}" : "products-level";
    }

    public function href(): string
    {
        return $this->category ? "#products-level-{$this->category->id}" : "#products-level";
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
        return view('admin.components.sidebar-menu-item-category-collapser-component');
    }
}
