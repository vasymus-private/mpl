<?php

namespace App\View\Components;

use App\DTOs\ViewedDTO;
use App\Models\Product\Product;
use App\Models\Service;
use App\Models\User\User;
use Carbon\Carbon;
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
        /** @var \App\Models\User\User $user */
        $user = Auth::user();
        $user->load([
            "viewed" => function(BelongsToMany $query) {
                $query->orderBy("pivot_created_at", "desc")->limit(5);
            },
            "serviceViewed" => function(BelongsToMany $query) {
                $query->orderBy("pivot_created_at", "desc")->limit(5);
            },
            "viewed.category.parentCategory"
        ]);

        $this->viewed = $user->viewed->merge($user->serviceViewed)
                    ->sort(function(Model $itemA, Model $itemB) {
                        $pivotA = $itemA instanceof Product
                                    ? $itemA->viewed_product
                                    : $itemA->viewed_service
                        ;
                        $pivotB = $itemB instanceof Product
                                    ? $itemB->viewed_product
                                    : $itemB->viewed_service
                        ;
                        $aCreatedAt = $pivotA->created_at ?? null;
                        $bCreatedAt = $pivotB->created_at ?? null;

                        $aCreatedAt = $aCreatedAt instanceof Carbon
                                        ? $aCreatedAt->getTimestamp()
                                        : (Carbon::canBeCreatedFromFormat($aCreatedAt, "Y-m-d H:i:s")
                                            ? Carbon::createFromFormat($aCreatedAt, "Y-m-d H:i:s")->getTimestamp()
                                            : null)
                        ;
                        $bCreatedAt = $bCreatedAt instanceof Carbon
                                        ? $bCreatedAt->getTimestamp()
                                        : (Carbon::canBeCreatedFromFormat($bCreatedAt, "Y-m-d H:i:s")
                                            ? Carbon::createFromFormat($bCreatedAt, "Y-m-d H:i:s")->getTimestamp()
                                            : null)
                        ;

                        return $bCreatedAt - $aCreatedAt;
                    })
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
