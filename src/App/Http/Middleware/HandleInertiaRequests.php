<?php

namespace App\Http\Middleware;

use Domain\Products\DTOs\Admin\CategoryItemSidebarDTO;
use Domain\Products\Models\Category;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Support\H;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => function () {
                $userOrAdmin = H::userOrAdmin();

                return [
                    'user' => $userOrAdmin
                        ? array_merge($userOrAdmin->only([
                            'id',
                            'name',
                            'email',
                            'phone',
                        ]), [
                            'is_anonymous' => $userOrAdmin->is_anonymous2,
                        ])
                        : null,
                ];
            },
            'flash' => function () use ($request) {
                return [
                    'success' => $request->session()->get('success'),
                    'error' => $request->session()->get('error'),
                ];
            },
            'categoriesTree' => function () {
                return Category::getTreeRuntimeCached()->map(fn (Category $category) => CategoryItemSidebarDTO::fromModel($category))->all();
            },
        ]);
    }
}
