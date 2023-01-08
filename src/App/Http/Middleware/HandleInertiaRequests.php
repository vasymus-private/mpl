<?php

namespace App\Http\Middleware;

use App\Http\Resources\Admin\Inertia\AvailabilityStatusResource;
use App\Http\Resources\Admin\Inertia\BillStatusResource;
use App\Http\Resources\Admin\Inertia\CharTypeResource;
use App\Http\Resources\Admin\Inertia\CurrencyResource;
use App\Http\Resources\Admin\Inertia\OrderImportanceResource;
use App\Http\Resources\Admin\Inertia\OrderStatusResource;
use App\Http\Resources\Admin\Inertia\PaymentMethodResource;
use Closure;
use DateInterval;
use Domain\Articles\Models\Article;
use Domain\Common\Enums\Column;
use Domain\Common\Models\Currency;
use Domain\FAQs\Models\FAQ;
use Domain\GalleryItems\Models\GalleryItem;
use Domain\Orders\Models\BillStatus;
use Domain\Orders\Models\OrderImportance;
use Domain\Orders\Models\OrderStatus;
use Domain\Orders\Models\PaymentMethod;
use Domain\Products\DTOs\Admin\CategoryItemSidebarDTO;
use Domain\Products\Models\AvailabilityStatus;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Category;
use Domain\Products\Models\CharType;
use Domain\Users\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Inertia\Middleware;
use Support\CBRcurrencyConverter\CBRcurrencyConverter;
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

    public function handle(Request $request, Closure $next)
    {
        if (! Route::is('admin*')) {
            return $next($request);
        }

        return parent::handle($request, $next);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'fullUrl' => $request->fullUrl(), // because of troubles of get full url on node js wrapper (for backend render via inertia)
            'auth' => function () {
                $userOrAdmin = H::userOrAdmin();

                return [
                    'user' => array_merge($userOrAdmin->only([
                        'id',
                        'name',
                        'email',
                        'phone',
                    ]), [
                        'is_anonymous' => $userOrAdmin->is_anonymous2,
                        'is_super_admin' => $userOrAdmin->is_super_admin,
                    ]),
                ];
            },
            'flash' => function () use ($request) {
                return [
                    'success' => $request->session()->get('success'),
                    'error' => $request->session()->get('error'),
                ];
            },
            'currencyTodayRate' => Cache::remember('currency-today-rate', new DateInterval('PT1H'), fn () => CBRcurrencyConverter::getTodayRates()),
            'categoriesTree' => Category::getTreeRuntimeCached()->map(fn (Category $category) => CategoryItemSidebarDTO::fromModel($category))->all(),
            'brandOptions' => Brand::getBrandOptions(),
            'adminOrderColumns' => H::admin()->admin_order_columns_arr,
            'adminProductColumns' => H::admin()->admin_product_columns_arr,
            'adminProductVariantColumns' => H::admin()->admin_product_variant_columns_arr,
            'adminSidebarFlexBasis' => H::admin()->admin_sidebar_flex_basis,
            'adminProductsColumnSizes' => collect(H::admin()->admin_products_column_sizes)->map([$this, '_columnSizeMapCB'])->filter()->all(),
            'adminProductVariationsColumnSizes' => collect(H::admin()->admin_product_variations_column_sizes)->map([$this, '_columnSizeMapCB'])->filter()->all(),
            'adminOrdersColumnSizes' => collect(H::admin()->admin_orders_column_sizes)->map([$this, '_columnSizeMapCB'])->filter()->all(),
            'availabilityStatuses' => AvailabilityStatusResource::collection(AvailabilityStatus::cachedAll()),
            'billStatuses' => BillStatusResource::collection(BillStatus::cachedAll()),
            'currencies' => CurrencyResource::collection(Currency::cachedAll()),
            'paymentMethods' => PaymentMethodResource::collection(PaymentMethod::cachedAll()),
            'orderImportance' => OrderImportanceResource::collection(OrderImportance::cachedAll()),
            'orderStatuses' => OrderStatusResource::collection(OrderStatus::cachedAll()),
            'charTypes' => CharTypeResource::collection(CharType::cachedAll()),
            'admins' => Admin::cachedAll()->map(fn (Admin $admin) => ['id' => $admin->id, 'name' => $admin->name, 'color' => $admin->admin_color]), // @phpstan-ignore-line
            'faqOptions' => FAQ::getFaqOptions(),
            'articleOptions' => Article::getArticleOptions(),
            'galleryItemOptions' => GalleryItem::getGalleryItemOption(),
            'categoryProductTypeOptions' => Category::getProductTypeOptions(),
        ]);
    }

    /**
     * @param string $value
     * @param int $key
     *
     * @return array|null
     */
    public function _columnSizeMapCB(string $value, int $key): ?array
    {
        $enum = Column::tryFrom($key);
        if (!$enum) {
            return null;
        }

        return [
            'column' => [
                'value' => $enum->value,
                'label' => $enum->label,
            ],
            'width' => $value,
        ];
    }
}
