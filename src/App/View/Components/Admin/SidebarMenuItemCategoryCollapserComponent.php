<?php

namespace App\View\Components\Admin;

use Domain\Products\Models\Category;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\HtmlString;

class SidebarMenuItemCategoryCollapserComponent extends BaseSidebarMenuItemCategoryComponent
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
        if (!$this->category) {
            $accessibilityHtml = $this->isActive() ? '<span class="sr-only">(current)</span>' : "";
            $text = "Каталог товаров $accessibilityHtml" . '<i class="bi bi-cart-fill" aria-hidden="true"></i>';
        } else {
            $text = $this->category->name;
        }

        return new HtmlString($text);
    }

    public function ariaExpanded(): string
    {
        return $this->isActive() ? "true" : "false";
    }

    public function ariaControls(): string
    {
        $baseIdHref = $this->getBaseIdHref();
        return $this->category ? "$baseIdHref-{$this->category->id}" : $baseIdHref;
    }

    public function href(): string
    {
        $baseIdHref = $this->getBaseIdHref();
        return $this->category ? "#$baseIdHref-{$this->category->id}" : "#$baseIdHref";
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
        return view('admin.components.sidebar-menu-item-category-collapser-component');
    }
}
