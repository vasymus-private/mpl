<?php

namespace App\Http\Middleware;

use App\Http\Resources\Admin\AvailabilityStatusResource;
use App\Http\Resources\Admin\BillStatusResource;
use App\Http\Resources\Admin\CharTypeResource;
use App\Http\Resources\Admin\CurrencyResource;
use App\Http\Resources\Admin\OrderImportanceResource;
use App\Http\Resources\Admin\OrderStatusResource;
use App\Http\Resources\Admin\PaymentMethodResource;
use Closure;
use DateInterval;
use Domain\Common\Models\Currency;
use Domain\Orders\Models\BillStatus;
use Domain\Orders\Models\OrderImportance;
use Domain\Orders\Models\OrderStatus;
use Domain\Orders\Models\PaymentMethod;
use Domain\Products\DTOs\Admin\CategoryItemSidebarDTO;
use Domain\Products\Models\AvailabilityStatus;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Category;
use Domain\Products\Models\CharType;
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
                    ]),
                ];
            },
            'flash' => function () use ($request) {
                return [
                    'success' => $request->session()->get('success'),
                    'error' => $request->session()->get('error'),
                ];
            },
            'currencyTodayRate' => Cache::remember('currency-today-rate', new DateInterval('PT1H'), fn() => CBRcurrencyConverter::getTodayRates()),
            'categoriesTree' => function () {
                return Category::getTreeRuntimeCached()->map(fn (Category $category) => CategoryItemSidebarDTO::fromModel($category))->all();
            },
            'brandOptions' => Brand::getBrandOptions(),
            'adminOrderColumns' => H::admin()->admin_order_columns_arr,
            'adminProductColumns' => H::admin()->admin_product_columns_arr,
            'adminProductVariantColumns' => H::admin()->admin_product_variant_columns_arr,
            'adminSidebarFlexBasis' => H::admin()->settings['adminSidebarFlexBasis'] ?? null,
            'availabilityStatuses' => AvailabilityStatusResource::collection(AvailabilityStatus::cachedAll()),
            'billStatuses' => BillStatusResource::collection(BillStatus::cachedAll()),
            'currencies' => CurrencyResource::collection(Currency::cachedAll()),
            'paymentMethods' => PaymentMethodResource::collection(PaymentMethod::cachedAll()),
            'orderImportance' => OrderImportanceResource::collection(OrderImportance::cachedAll()),
            'orderStatuses' => OrderStatusResource::collection(OrderStatus::cachedAll()),
            'charTypes' => CharTypeResource::collection(CharType::cachedAll()),
        ]);
    }
}
