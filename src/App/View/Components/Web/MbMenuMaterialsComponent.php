<?php

namespace App\View\Components\Web;

use Domain\Products\Models\Category;
use Illuminate\View\Component;

class MbMenuMaterialsComponent extends Component
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Domain\Products\Models\Category[]
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
        return view('web.components.mb-menu-materials-component');
    }
}
