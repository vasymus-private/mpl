<?php

namespace App\View\Components;

use App\DTOs\ViewedDTO;
use App\Models\Product\Product;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class SidebarMenuViewedComponent extends Component
{
    /**
     * @var Collection|ViewedDTO[]
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
                $query->orderBy("pivot_created_at", "desc")->limit(5);
            },
            "serviceViewed" => function(BelongsToMany $query) {
                $query->orderBy("pivot_created_at", "desc")->limit(5);
            }
        ]);
        $this->viewed = $user->viewed->merge($user->serviceViewed)
                    ->sortByDesc("pivot_created_at")
                    ->map(function(Model $item) {
                        $web_route = $item instanceof Product
                                        ? $item->web_route
                                        : ($item instanceof Service
                                            ? $item->web_route
                                            : "")
                        ;
                        $image_url = $item instanceof Product
                                        ? $item->main_image_url
                                        : ($item instanceof Service
                                            ? "" // TODO main service image
                                            : "")
                        ;
                        $name = $item instanceof Product
                                    ? $item->name
                                    : ($item instanceof Service
                                        ? $item->name
                                        : "")
                        ;
                        return new ViewedDTO([
                            "web_route" => $web_route,
                            "image_url" => $image_url,
                            "name" => $name,
                        ]);
                    })
                    ->filter(function(ViewedDTO $dto) {
                        return (bool)$dto->web_route && (bool)$dto->name;
                    })
                    ->take(5)
        ;
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
