<?php

namespace App\Http\Livewire\Admin\ShowOrder;

use App\Constants;
use App\Http\Livewire\Admin\BaseShowComponent;
use App\Http\Livewire\Admin\HasBillStatuses;
use App\Http\Livewire\Admin\HasManagers;
use App\Http\Livewire\Admin\HasOrderImportance;
use App\Http\Livewire\Admin\HasOrderStatuses;
use App\Http\Livewire\Admin\HasPagination;
use App\Http\Livewire\Admin\HasPaymentMethods;
use App\Http\Livewire\Admin\HasTabs;
use Domain\Common\DTOs\FileDTO;
use Domain\Common\DTOs\SearchPrependAdminDTO;
use Domain\Common\Models\Currency;
use Domain\Common\Models\CustomMedia;
use Domain\Orders\Actions\DefaultUpdateOrderAction;
use Domain\Orders\Actions\DeleteOrderAction;
use Domain\Orders\Actions\HandleCancelOrderAction;
use Domain\Orders\Actions\HandleNotCancelOrderAction;
use Domain\Orders\Actions\OMS\HandleChangeOrderStatusAction;
use Domain\Orders\Actions\UpdateOrderCustomerInvoicesAction;
use Domain\Orders\DTOs\DefaultUpdateOrderParams;
use Domain\Orders\DTOs\OrderHistoryItem;
use Domain\Orders\DTOs\UpdateOrderInvoicesParamsDTO;
use Domain\Orders\Enums\OrderEventType;
use Domain\Orders\Models\BillStatus;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderEvent;
use Domain\Orders\Models\OrderImportance;
use Domain\Orders\Models\OrderStatus;
use Domain\Orders\Models\PaymentMethod;
use Domain\Products\DTOs\Admin\CategoryItemSidebarDTO;
use Domain\Products\DTOs\Admin\OrderAdditionalProductItemDTO;
use Domain\Products\DTOs\Admin\OrderProductItemDTO;
use Domain\Products\Models\Category;
use Domain\Products\Models\Product\Product;
use Domain\Users\Models\Admin;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Support\H;

class ShowOrder extends BaseShowComponent
{
    use HasTabs;
    use HasOrderStatuses;
    use HasPaymentMethods;
    use HasManagers;
    use HasOrderImportance;
    use HasBillStatuses;
    use WithFileUploads;

    // pagination is needed for additional product items in modal
    use WithPagination {
        setPage as protected _setPage;
    }
    use HasPagination;

    protected const DEFAULT_PER_PAGE = 20;

    protected const DEFAULT_TAB = 'order';
    public const MAX_FILE_SIZE_MB = 30;

    /**
     * @var int|string
     */
    public $total = 0;

    /**
     * @var int|string
     */
    public $last_page;

    /**
     * @var int|string
     */
    public $per_page;

    /**
     * @var string
     */
    public $search;

    /**
     * @var string|int|null
     */
    public $editMode = '0';

    /**
     * @var bool
     */
    public bool $isCreating;

    /**
     * @var string
     */
    public string $cancelMessage = '';

    /**
     * @var string
     */
    public string $email = '';

    /**
     * @var string
     */
    public string $name = '';

    /**
     * @var string
     */
    public string $phone = '';

    /**
     * @var array[] @see {@link \Domain\Common\DTOs\SearchPrependAdminDTO}
     */
    public array $productItemsFilters = [];

    /**
     * @var string|int|null
     */
    public $categoryId;

    /**
     * @var array[] @see {@link \Domain\Common\DTOs\FileDTO}
     */
    public array $customerInvoices;

    /**
     * @var array[] @see {@link \Domain\Common\DTOs\FileDTO}
     */
    public array $supplierInvoices;

    /**
     * @var array @see {@link \Domain\Products\DTOs\Admin\OrderProductItemDTO}
     */
    public array $currentProductItem;

    /**
     * @var array @see {@link \Domain\Products\DTOs\Admin\OrderProductItemDTO}
     */
    public array $initialCurrentProductItem;

    /**
     * @var array[] @see {@link \Domain\Products\DTOs\Admin\OrderProductItemDTO}
     */
    public array $productItems;

    /**
     * @var array[] @see {@link \Domain\Products\DTOs\Admin\OrderAdditionalProductItemDTO}
     */
    public array $additionalProductItems = [];

    /**
     * @var \Livewire\TemporaryUploadedFile
     */
    public $tempCustomerInvoice;

    /**
     * @var \Livewire\TemporaryUploadedFile
     */
    public $tempSupplierInvoice;

    /**
     * @var \Domain\Products\DTOs\Admin\CategoryItemSidebarDTO[]
     * */
    public array $categoriesSidebar;

    /**
     * @var \Domain\Orders\Models\Order
     */
    public Order $item;

    /**
     * @var array[] @see {@link \Domain\Orders\DTOs\OrderHistoryItem}
     */
    public array $orderHistoryItems = [];

    public function tabs(): array
    {
        return $this->isCreating
            ? [
                'order' => 'Заказ',
            ]
            : [
                'order' => 'Заказ',
                'history' => 'История изменений',
            ];
    }

    /**
     * @return array
     */
    protected function queryString(): array
    {
        return array_merge(
            $this->getHasTabsQueryString(),
            [
                'editMode' => ['except' => '0'],
            ]
        );
    }

    /**
     * @return string[]
     */
    protected function rules(): array
    {
        return [
            'item.order_status_id' => sprintf('required|exists:%s,id', OrderStatus::class),
            'item.payment_method_id' => sprintf('required|exists:%s,id', PaymentMethod::class),
            'item.comment_user' => 'nullable|max:65000',
            'item.admin_id' => sprintf('nullable|exists:%s,id', Admin::class),
            'item.importance_id' => sprintf('nullable|exists:%s,id', OrderImportance::class),
            'item.customer_bill_status_id' => sprintf('required|exists:%s,id', BillStatus::class),
            'item.customer_bill_description' => 'nullable|max:65000',
            'item.provider_bill_status_id' => sprintf('required|exists:%s,id', BillStatus::class),
            'item.provider_bill_description' => 'nullable|max:65000',
            'item.comment_admin' => 'nullable|max:65000',

            'customerInvoices.*.name' => 'nullable|max:250',
            'supplierInvoices.*.name' => 'nullable|max:250',
            'tempCustomerInvoice' => sprintf('nullable|max:%s', 1024 * self::MAX_FILE_SIZE_MB), // 1024 -> 1024 kb = 1 mb
            'tempSupplierInvoice' => sprintf('nullable|max:%s', 1024 * self::MAX_FILE_SIZE_MB), // 1024 -> 1024 kb = 1 mb

            'productItems.*.order_product_count' => 'nullable',
            'productItems.*.order_product_price_retail_rub' => 'nullable',
        ];
    }

    public function mount()
    {
        $this->isCreating = Route::currentRouteName() === Constants::ROUTE_ADMIN_ORDERS_CREATE;

        $this->initOrderStatusesOptions();
        $this->initPaymentMethodsOptions();
        $this->initManagersOptions();
        $this->initOrderImportanceOptions();
        $this->initBillStatusesOptions();
        $this->initCustomerInvoices();
        $this->initSupplierInvoices();

        $this->initHasTabs();

        $this->email = $this->item->request['email'] ?? $this->item->user->email ?? '';
        $this->name = $this->item->request['name'] ?? $this->item->user->name ?? '';
        $this->phone = $this->item->request['phone'] ?? $this->item->user->phone ?? '';

        $this->initProductItems();
        $this->initCategoriesSidebar();

        $this->fetchAdditionalProductItems();
        $this->mountPerPageOptions();
        $this->mountAdditionalProductItemsPerPage();
        $this->initHistory();
    }

    public function render()
    {
        return view('admin.livewire.show-order.show-order', [
            'additionalProductItemsPaginator' => (new LengthAwarePaginator(
                $this->additionalProductItems,
                $this->total,
                $this->per_page,
                $this->page,
            ))->onEachSide(1),
        ]);
    }

    public function handleSave()
    {
        $this->validate();

        $this->saveItem();
        $this->saveInvoices();
        $this->saveOrderItems();

        // todo (think of do refresh)
        $this->initHistory();
    }

    protected function saveItem()
    {
        $defaultUpdateOrderAction = resolve(DefaultUpdateOrderAction::class);

        $defaultUpdateOrderAction->execute(new DefaultUpdateOrderParams([
            'order' => $this->getFreshOrder(),
            'user' => H::admin(),
            'comment_user' => $this->item->comment_user,
            'comment_admin' => $this->item->comment_admin,
            'payment_method_id' => $this->item->payment_method_id,
            'admin_id' => $this->item->admin_id,
            'importance_id' => $this->item->importance_id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]));

        /** @var \Domain\Orders\Actions\OMS\HandleChangeOrderStatusAction $handleChangeOrderStatusAction */
        $handleChangeOrderStatusAction = resolve(HandleChangeOrderStatusAction::class);
        $handleChangeOrderStatusAction->execute(
            $this->getFreshOrder(),
            $this->item->order_status_id,
            H::admin()
        );
    }

    protected function saveOrderItems()
    {
        $productsPrepare = [];

        /** @var array @see {@link \Domain\Products\DTOs\Admin\OrderProductItemDTO} $productItem */
        foreach ($this->productItems as $productItem) {
            $prepared = [
                'count' => $productItem['order_product_count'],
                'name' => $productItem['name'],
                'unit' => $productItem['unit'],
                'price_retail_rub' => $productItem['order_product_price_retail_rub'],
                'price_retail_rub_was_updated' => $productItem['order_product_price_retail_rub_was_updated'],
            ];
            /** @var \Domain\Products\Models\Product\Product $currentOrderProduct */
            $currentOrderProduct = $this->item->products->first(fn(Product $product) => (string)$product->id === (string)$productItem['id']);
            if ($currentOrderProduct) {
                $productsPrepare[$productItem['id']] = array_merge($prepared, [
                    'price_purchase' => $currentOrderProduct->order_product->price_purchase,
                    'price_purchase_currency_id' => $currentOrderProduct->order_product->price_purchase_currency_id,
                    'price_retail' => $currentOrderProduct->order_product->price_retail,
                    'price_retail_currency_id' => $currentOrderProduct->order_product->price_retail_currency_id,
                    'price_retail_rub_origin' => $currentOrderProduct->order_product->price_retail_rub_origin,

                ]);
                continue;
            }

            $currentProduct = Product::query()->findOrFail($productItem['id']);
            $productsPrepare[$productItem['id']] = array_merge($prepared, [
                'price_purchase' => $currentProduct->price_purchase,
                'price_purchase_currency_id' => $currentProduct->price_purchase_currency_id,
                'price_retail' => $currentProduct->price_retail,
                'price_retail_currency_id' => $currentProduct->price_retail_currency_id,
                'price_retail_rub_origin' => $currentProduct->price_retail_rub,
            ]);
        }

        $this->item->products()->sync($productsPrepare);
    }

    public function handleDeleteOrder()
    {
        /** @var \Domain\Orders\Actions\DeleteOrderAction $deleteOrder */
        $deleteOrder = resolve(DeleteOrderAction::class);
        $deleteOrder->execute($this->item, H::admin());
        return redirect()->route(Constants::ROUTE_ADMIN_ORDERS_INDEX);
    }

    public function handleCancelOrder()
    {
        if ($this->isCreating) {
            $this->skipRender();
            return false;
        }

        /** @var \Domain\Orders\Actions\HandleCancelOrderAction $handleCancelOrderAction */
        $handleCancelOrderAction = resolve(HandleCancelOrderAction::class);
        $handleCancelOrderAction->execute($this->item, $this->cancelMessage, H::admin());

        $this->initHistory();

        return true;
    }

    public function handleNotCancelled()
    {
        if ($this->isCreating) {
            $this->skipRender();
            return false;
        }

        /** @var \Domain\Orders\Actions\HandleNotCancelOrderAction $handleNotCancelOrderAction */
        $handleNotCancelOrderAction = resolve(HandleNotCancelOrderAction::class);
        $handleNotCancelOrderAction->execute($this->item, H::admin());

        $this->initHistory();

        return true;
    }

    public function isEditMode(): bool
    {
        return (int)$this->editMode !== 0;
    }

    public function deleteCustomerInvoice($index)
    {
        $this->customerInvoices = collect($this->customerInvoices)->values()->filter(fn(array $attachment, int $key) => (string)$index !== (string)$key)->toArray();
    }

    public function deleteSupplierInvoice($index)
    {
        $this->supplierInvoices = collect($this->supplierInvoices)->values()->filter(fn(array $attachment, int $key) => (string)$index !== (string)$key)->toArray();
    }

    /**
     * @param \Livewire\TemporaryUploadedFile $value
     */
    public function updatedTempCustomerInvoice(TemporaryUploadedFile $value)
    {
        $fileDTO = FileDTO::fromTemporaryUploadedFile($value);
        $this->customerInvoices[] = $fileDTO->toArray();
    }

    /**
     * @param \Livewire\TemporaryUploadedFile $value
     */
    public function updatedTempSupplierInvoice(TemporaryUploadedFile $value)
    {
        $fileDTO = FileDTO::fromTemporaryUploadedFile($value);
        $this->supplierInvoices[] = $fileDTO->toArray();
    }

    public function removeProductItem($id)
    {
        $this->productItems = collect($this->productItems)->filter(fn(array $productItem) => (string)$productItem['id'] !== (string)$id)->toArray();
    }

    public function selectCurrentProductItem($uuid)
    {
        $orderProductItem = $this->productItems[$uuid];

        if (!$orderProductItem) {
            return false;
        }

        $this->currentProductItem = $orderProductItem;
        $this->initialCurrentProductItem = $orderProductItem;
        return true;
    }

    protected function initCustomerInvoices()
    {
        $this->customerInvoices = $this->item
            ->customer_invoices
            ->map(
                fn(CustomMedia $media) => FileDTO::fromCustomMedia($media)->toArray()
            )
            ->toArray();
    }

    protected function initSupplierInvoices()
    {
        $this->supplierInvoices = $this->item
            ->supplier_invoices
            ->map(
                fn(CustomMedia $media) => FileDTO::fromCustomMedia($media)->toArray()
            )
            ->toArray();
    }

    protected function saveInvoices()
    {
        $updateOrderCustomerInvoicesAction = resolve(UpdateOrderCustomerInvoicesAction::class);
        $updateOrderCustomerInvoicesAction->execute(new UpdateOrderInvoicesParamsDTO([
            'order' => $this->getFreshOrder(),
            'customer_bill_status_id' => $this->item->customer_bill_status_id,
            'customer_bill_description' => $this->item->customer_bill_description,
            'customerInvoices' => $this->customerInvoices,
            'provider_bill_status_id' => $this->item->provider_bill_status_id,
            'provider_bill_description' => $this->item->provider_bill_description,
            'supplierInvoices' => $this->supplierInvoices,
            'user' => H::admin(),
        ]));
    }

    protected function initProductItems()
    {
        $this->productItems = $this->item->products->map(fn(Product $product) => OrderProductItemDTO::fromOrderProductItem($product)->toArray())->keyBy('uuid')->sortBy('id')->all();
    }

    protected function initCategoriesSidebar()
    {
        $this->categoriesSidebar = Category::getTreeRuntimeCached()->map(fn(Category $category) => CategoryItemSidebarDTO::fromModel($category)->toArray())->all();
    }

    /**
     * @param string $value
     * @param string $field
     */
    public function updatedProductItems($value, $field)
    {
        $uuidItemFieldArr = explode('.', $field);
        $uuid = $uuidItemFieldArr[0];
        $itemField = $uuidItemFieldArr[1];

        $orderProductItem = $this->productItems[$uuid];
        $orderProductItem = $this->handleUpdateProductItem($orderProductItem, $itemField, $value);

        $this->productItems[$uuid] = $orderProductItem;
    }

    public function handleSaveCurrentProductItem()
    {
        if (!$this->currentProductItem) {
            return false;
        }
        $productItemToUpdate = $this->productItems[$this->currentProductItem['uuid']];

        $possibleFieldsToUpdate = ['name', 'unit', 'order_product_price_retail_rub', 'order_product_count'];
        foreach ($possibleFieldsToUpdate as $itemField) {
            if ($this->currentProductItem[$itemField] !== $this->initialCurrentProductItem[$itemField]) {
                $productItemToUpdate = $this->handleUpdateProductItem($productItemToUpdate, $itemField, $this->currentProductItem[$itemField]);
            }
        }
        $this->productItems[$this->currentProductItem['uuid']] = $productItemToUpdate;

        return true;
    }

    /**
     * @param array|\Domain\Products\DTOs\Admin\OrderProductItemDTO $orderProductItem
     * @param string $itemField
     * @param int|string $value
     *
     * @return array|\Domain\Products\DTOs\Admin\OrderProductItemDTO
     */
    protected function handleUpdateProductItem(array $orderProductItem, string $itemField, $value): array
    {
        switch ($itemField) {
            case 'order_product_count': {
                $orderProductItem['order_product_price_retail_rub_sum'] = (int)$value * $orderProductItem['order_product_price_retail_rub'];
                $orderProductItem['order_product_price_retail_rub_sum_formatted'] = H::priceRubFormatted($orderProductItem['order_product_price_retail_rub_sum'], Currency::ID_RUB);
                $orderProductItem['order_product_price_purchase_rub_sum'] = (int)$value * $orderProductItem['price_purchase_rub'];
                $orderProductItem['order_product_price_purchase_rub_sum_formatted'] = H::priceRubFormatted($orderProductItem['order_product_price_purchase_rub_sum'], Currency::ID_RUB);
                $orderProductItem['order_product_diff_rub_price_retail_sum_price_purchase_sum_formatted'] = H::priceRubFormatted($orderProductItem['order_product_price_retail_rub_sum'] - $orderProductItem['order_product_price_purchase_rub_sum'], Currency::ID_RUB);
                $orderProductItem[$itemField] = $value;
                break;
            }
            case 'order_product_price_retail_rub': {
                $orderProductItem['order_product_price_retail_rub_was_updated'] = true;
                $orderProductItem['order_product_price_retail_rub_formatted'] = H::priceRubFormatted((int)$value, Currency::ID_RUB);
                $orderProductItem['order_product_price_retail_rub_sum'] = (int)$value * $orderProductItem['order_product_count'];
                $orderProductItem['order_product_price_retail_rub_sum_formatted'] = H::priceRubFormatted($orderProductItem['order_product_price_retail_rub_sum'], Currency::ID_RUB);
                $orderProductItem['order_product_diff_rub_price_retail_sum_price_purchase_sum_formatted'] = H::priceRubFormatted($orderProductItem['order_product_price_retail_rub_sum'] - $orderProductItem['order_product_price_purchase_rub_sum'], Currency::ID_RUB);
                $orderProductItem[$itemField] = $value;
                break;
            }
            default: {
                $orderProductItem[$itemField] = $value;
            }
        }

        return $orderProductItem;
    }

    /**
     * @return array[] $prepends @see {@link \Domain\Common\DTOs\SearchPrependAdminDTO}
     */
    public function getProductItemsFilters(): array
    {
        return $this->productItemsFilters;
    }

    public function setProductItemFilter($categoryId = null)
    {
        if (!$categoryId) {
            $this->categoryId = null;
            $this->productItemsFilters = [];
            $this->fetchAdditionalProductItems();
            return;
        }
        $category = Category::query()->findOrFail($categoryId);
        $this->productItemsFilters = [];

        $this->productItemsFilters[] = (new SearchPrependAdminDTO([
            'label' => $category->name,
            'onClear' => 'clearProductItemFilter',
        ]))->toArray();
        $this->categoryId = $category->id;
        $this->fetchAdditionalProductItems();
    }

    protected function setAdditionalProductItems(array $items)
    {
        $this->additionalProductItems = collect($items)->map(fn(Product $product) => OrderAdditionalProductItemDTO::create($product)->toArray())->keyBy('uuid')->toArray();
    }

    protected function fetchAdditionalProductItems()
    {
        $query = Product::query()->notVariations()->with(['variations', 'variations.media', 'variations.parent', 'media']);
        if ($this->categoryId) {
            $query->where(sprintf('%s.category_id', Product::TABLE), $this->categoryId);
        }
        if ($this->search) {
            $query->where(sprintf('%s.name', Product::TABLE), 'like', sprintf('%%%s%%', $this->search));
        }

        $paginator = $this->getPaginator($query);

        $this->setAdditionalProductItems($paginator->items());
    }

    public function clearAllFilters()
    {
        $this->search = '';
        $this->categoryId = null;
        $this->productItemsFilters = [];
        $this->fetchAdditionalProductItems();
    }

    public function setPage($page)
    {
        $this->_setPage($page);
        $this->fetchAdditionalProductItems();
    }

    public function handleAdditionalProductItemsSearch()
    {
        $this->fetchAdditionalProductItems();
    }

    public function mountAdditionalProductItemsPerPage()
    {
        $this->per_page = $this->getDefaultPerPage();
    }

    public function addProductItemToOrder(string $uuid)
    {
        $product = Product::query()
            ->where(
                sprintf('%s.uuid', Product::TABLE),
                $uuid
            )
            ->firstOrFail();

        $this->productItems[$uuid] = $this->createOrderProductItemFromProduct(
            $product,
            (isset($this->productItems[$uuid])
                ? $this->productItems[$uuid]['order_product_count'] + 1
                : 1),
            (isset($this->productItems[$uuid])
                ? $this->productItems[$uuid]['price_retail_rub_was_updated']
                : false)
        )->toArray();
    }

    public function toggleShowVariations(string $uuid)
    {
        $productItem = $this->additionalProductItems[$uuid];
        $productItem['showVariations'] = !$productItem['showVariations'];
        $this->additionalProductItems[$uuid] = $productItem;
    }

    /**
     * @param \Domain\Products\Models\Product\Product $product
     * @param int $count
     * @param bool $priceRetailRubWasUpdated
     *
     * @return \Domain\Products\DTOs\Admin\OrderProductItemDTO
     */
    protected function createOrderProductItemFromProduct(Product $product, int $count = 1, bool $priceRetailRubWasUpdated = false): OrderProductItemDTO
    {
        $order_product_price_purchase_rub_sum = $count * $product->price_purchase_rub;
        $order_product_price_retail_rub = $product->price_retail_rub;
        $order_product_price_retail_rub_sum = $order_product_price_retail_rub * $count;

        return new OrderProductItemDTO([
            'id' => $product->id,
            'uuid' => $product->uuid,
            'name' => $product->name,
            'order_product_count' => $count,
            'unit' => $product->unit,
            'coefficient' => $product->coefficient,
            'availability_status_name' => $product->availability_status_name,
            'image' => $product->main_image_sm_thumb_url,
            'price_purchase_rub' => $product->price_purchase_rub,
            'price_purchase_rub_formatted' => $product->price_purchase_rub_formatted,
            'price_purchase' => $product->price_purchase,
            'price_purchase_currency_id' => $product->price_purchase_currency_id,
            'admin_route' => $product->admin_route,

            // order product and calculated props
            'order_product_price_purchase_rub_sum' => $order_product_price_purchase_rub_sum,
            'order_product_price_purchase_rub_sum_formatted' => H::priceRubFormatted($order_product_price_purchase_rub_sum, Currency::ID_RUB),
            'order_product_price_retail_rub' => $order_product_price_retail_rub,
            'order_product_price_retail_rub_formatted' => H::priceRubFormatted($order_product_price_retail_rub, Currency::ID_RUB),
            'order_product_price_retail_rub_sum' => $order_product_price_retail_rub_sum,
            'order_product_price_retail_rub_sum_formatted' => H::priceRubFormatted($order_product_price_retail_rub_sum, Currency::ID_RUB),
            'order_product_diff_rub_price_retail_sum_price_purchase_sum_formatted' => H::priceRubFormatted($order_product_price_retail_rub_sum - $order_product_price_purchase_rub_sum, Currency::ID_RUB),
            'order_product_price_retail_rub_origin_formatted' => H::priceRubFormatted($order_product_price_retail_rub, Currency::ID_RUB),
            'order_product_price_retail_rub_was_updated' => $priceRetailRubWasUpdated,
        ]);
    }

    protected function initHistory()
    {
        $this->item->load(['events', 'events.user']);
        $this->orderHistoryItems = $this->item->events
            ->map(
                fn(OrderEvent $orderEvent) => (new OrderHistoryItem([
                    'orderEventId' => $orderEvent->id,
                    'userName' => $orderEvent->user->name ?? null,
                    'operation' => $this->getOperation($orderEvent->type),
                    'description' => $orderEvent->payload['description'] ?? '',
                    'date' => $orderEvent->created_at ? $orderEvent->created_at->format('Y-m-d H:i:s') : null,
                ]))->toArray()
            )
            ->toArray();
    }

    /**
     * @param \Domain\Orders\Enums\OrderEventType $orderEventType
     *
     * @return string
     */
    protected function getOperation(OrderEventType $orderEventType): string
    {
        /**
Изменение цены товара
Изменение количества товара
Изменение упаковки товара
Изменение названия товара
Добавление товара
Удаление товара
         */
        switch (true) {
            case $orderEventType->equals(OrderEventType::checkout()) :
            case $orderEventType->equals(OrderEventType::admin_created()) : {
                return 'Создание заказа';
            }
            case $orderEventType->equals(OrderEventType::update_comment_admin()) : {
                return 'Комментарий к заказу';
            }
            case $orderEventType->equals(OrderEventType::update_status()) : {
                return 'Изменение статуса заказа';
            }
            case $orderEventType->equals(OrderEventType::update_customer_personal_data()) : {
                return 'Изменение параметров покупателя';
            }
            case $orderEventType->equals(OrderEventType::update_payment_method()) : {
                return 'Изменение способа оплаты';
            }
            case $orderEventType->equals(OrderEventType::update_comment_user()) : {
                return 'Изменение комментария пользователя';
            }
            case $orderEventType->equals(OrderEventType::update_admin()) : {
                return 'Изменение менеджера';
            }
            case $orderEventType->equals(OrderEventType::update_importance()) : {
                return 'Изменение важности';
            }
            case $orderEventType->equals(OrderEventType::update_customer_invoice()) : {
                return 'Изменение счёта покупателя';
            }
            case $orderEventType->equals(OrderEventType::update_supplier_invoice()) : {
                return 'Изменение счёта от поставщика';
            }
            case $orderEventType->equals(OrderEventType::cancellation()) : {
                return 'Отмена заказа';
            }
            case $orderEventType->equals(OrderEventType::delete()) : {
                return 'Удаление заказа';
            }
            default : {
                return '';
            }
        }
    }

    /**
     * @return \Domain\Orders\Models\Order
     */
    protected function getFreshOrder(): Order
    {
        return Cache::store('array')->rememberForever(
            sprintf('fresh-db-order-%s', $this->item->id),
            fn() => $this->isCreating ? $this->item : Order::query()->findOrFail($this->item->id)
        );
    }
}
