<?php

namespace App\View\Components;

use App\Models\Product\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class SidebarMenuViewedComponent extends Component
{
    /**
     * @var Collection|Product[]
     * */
    public $viewed;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        /** @var User $user */
        $user = Auth::user();
        $user->load([
            "viewed" => function(BelongsToMany $query) {
                $query->orderBy("pivot_created_at", "desc");
            }
        ]);
        $this->viewed = $user->viewed;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('web.components.sidebar-menu-viewed-component');
    }
}
