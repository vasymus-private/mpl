<?php

namespace App\View\Components\Web;

use Carbon\Carbon;
use Domain\Products\DTOs\ViewedDTO;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\View\Component;
use Support\H;

class SidebarMenuViewedComponent extends Component
{
    /**
     * @var \Illuminate\Support\Collection<array-key, \Domain\Products\DTOs\ViewedDTO>
     * */
    public $viewed;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $user = H::userOrAdmin();
        $user->load([
            "viewed" => function (BelongsToMany $query) {
                $query->orderBy("pivot_created_at", "desc")->limit(5);
            },
            "viewed.category.parentCategory",
        ]);
        /** @var \Illuminate\Database\Eloquent\Collection<array-key, \Domain\Products\Models\Product\Product> $viewed */
        $viewed = new Collection([]);

        $this->viewed = $viewed
            ->merge($user->viewed)
            ->sort(function (Model $itemA, Model $itemB) {
                /**
                 * @var \Domain\Products\Models\Product\Product $itemA
                 * @var \Domain\Products\Models\Product\Product $itemB
                 */
                $pivotA = $itemA->viewed_product;
                $pivotB = $itemB->viewed_product;

                $aCreatedAt = $pivotA->created_at ?? null;
                $bCreatedAt = $pivotB->created_at ?? null;

                $aCreatedAt = $aCreatedAt instanceof Carbon
                                ? $aCreatedAt->getTimestamp()
                                : 0;
                $bCreatedAt = $bCreatedAt instanceof Carbon
                                ? $bCreatedAt->getTimestamp()
                                : 0;

                return $bCreatedAt - $aCreatedAt;
            })
            ->map(function (Model $item) {
                /**
                 * @var \Domain\Products\Models\Product\Product $item
                 */
                $web_route = $item->web_route;
                $image_url = $item->main_image_url;
                $name = $item->name;

                return new ViewedDTO([
                    "web_route" => $web_route,
                    "image_url" => $image_url,
                    "name" => $name,
                ]);
            })
            ->filter(function (ViewedDTO $dto) {
                return $dto->web_route && $dto->name;
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
