<?php

namespace App\View\Components\Web;

use Domain\Products\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class SidebarMenuMaterialsComponent extends Component
{
    /**
     * @var Collection|\Domain\Products\Models\Category[]
     * */
    public $categories;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Domain\Products\Models\Category[]
     */
    public $parquetWorkCategories;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->categories = Category::query()->parents()->active()->ordering()->parquetMaterials()->with("subcategories.subcategories.subcategories")->get();
        $this->parquetWorkCategories = Category::query()->parents()->active()->ordering()->parquetWorks()->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('web.components.sidebar-menu-materials-component');
    }
}
