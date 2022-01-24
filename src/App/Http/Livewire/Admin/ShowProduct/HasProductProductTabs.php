<?php

namespace App\Http\Livewire\Admin\ShowProduct;

use Domain\Products\Actions\GetCategoryAndSubtreeIdsAction;
use Domain\Products\DTOs\Admin\ProductProductDTO;
use Domain\Products\Models\Category;
use Domain\Products\Models\Pivots\ProductProduct;
use Domain\Products\Models\Product\Product;

/**
 * @mixin \App\Http\Livewire\Admin\ShowProduct\ShowProduct
 * @mixin \App\Http\Livewire\Admin\ShowProduct\BaseShowProduct
 */
trait HasProductProductTabs
{
    protected static array $initLoadedProductProduct = [
        ProductProduct::TYPE_ACCESSORY => [],
        ProductProduct::TYPE_SIMILAR => [],
        ProductProduct::TYPE_RELATED => [],
        ProductProduct::TYPE_WORK => [],
        ProductProduct::TYPE_INSTRUMENT => [],
    ];

    protected static array $initSearchForProductProduct = [
        ProductProduct::TYPE_ACCESSORY => [
            'category_id' => null,
            'product_name' => null,
        ],
        ProductProduct::TYPE_SIMILAR => [
            'category_id' => null,
            'product_name' => null,
        ],
        ProductProduct::TYPE_RELATED => [
            'category_id' => null,
            'product_name' => null,
        ],
        ProductProduct::TYPE_WORK => [
            'category_id' => null,
            'product_name' => null,
        ],
        ProductProduct::TYPE_INSTRUMENT => [
            'category_id' => null,
            'product_name' => null,
        ],
    ];

    protected array $mapTypeToRelationName = [
        /** @see \Domain\Products\Models\Product\Product::accessory() */
        ProductProduct::TYPE_ACCESSORY => 'accessory',

        /** @see \Domain\Products\Models\Product\Product::similar() */
        ProductProduct::TYPE_SIMILAR => 'similar',

        /** @see \Domain\Products\Models\Product\Product::related() */
        ProductProduct::TYPE_RELATED => 'related',

        /** @see \Domain\Products\Models\Product\Product::works() */
        ProductProduct::TYPE_WORK => 'works',

        /** @see \Domain\Products\Models\Product\Product::instruments() */
        ProductProduct::TYPE_INSTRUMENT => 'instruments',
    ];

    /**
     * @var array[][] @see {@link \Domain\Products\DTOs\Admin\ProductProductDTO}
     */
    public array $productProducts = [
        ProductProduct::TYPE_ACCESSORY => [],
        ProductProduct::TYPE_SIMILAR => [],
        ProductProduct::TYPE_RELATED => [],
        ProductProduct::TYPE_WORK => [],
        ProductProduct::TYPE_INSTRUMENT => [],
    ];

    /**
     * @var array[][] @see {@link \Domain\Products\DTOs\Admin\ProductProductDTO}
     */
    public array $loadedForProductProduct = [];

    /**
     * @var array[]
     */
    public array $searchForProductProduct = [];

    protected function getProductProductTabsRules(): array
    {
        return [
            'item.accessory_name' => 'required|max:250',
            'item.similar_name' => 'required|max:250',
            'item.related_name' => 'required|max:250',
            'item.work_name' => 'required|max:250',
            'item.instruments_name' => 'required|max:250',

            'productProducts.*.*.toDelete' => 'nullable|boolean',
            'loadedForProductProduct.*.*.isSelected' => 'nullable|boolean',

            'searchForProductProduct.*.category_id' => 'nullable|integer|exists:' . Category::class . ',id',
            'searchForProductProduct.*.product_name' => 'nullable',
        ];
    }

    /**
     * @return string[]
     */
    protected function getProductProductTabsMessages(): array
    {
        return [

        ];
    }

    protected function initProductProductTabs()
    {
        $this->initLoadedForProductProduct();
        $this->initSearchForProductProduct();

        $product = $this->item;

        if ($this->isCreatingFromCopy) {
            $originProduct = $this->getOriginProduct();
            $product = $originProduct ?: $product;
        }

        $this->initProductProduct($product);
    }

    protected function getProductProductTabsAttributes(): array
    {
        return [
            'accessory_name' => $this->item->accessory_name,
            'similar_name' => $this->item->similar_name,
            'related_name' => $this->item->related_name,
            'work_name' => $this->item->work_name,
            'instruments_name' => $this->item->instruments_name,
        ];
    }

    protected function handleSaveProductProductTabs()
    {
        $this->saveProductProduct();
    }

    public function loadProductProduct(int $for)
    {
        if (! in_array($for, ProductProduct::ALL_TYPES)) {
            return;
        }

        $filters = $this->searchForProductProduct[$for];
        $category_id = (int)$filters['category_id'];
        $product_name = (string)$filters['product_name'];

        if (! $category_id && ! $product_name) {
            return;
        }

        $productQuery = Product::query()->notVariations();

        if ($category_id) {
            /** @var \Domain\Products\Actions\GetCategoryAndSubtreeIdsAction $getCategoryAndSubtreeIdsAction */
            $getCategoryAndSubtreeIdsAction = resolve(GetCategoryAndSubtreeIdsAction::class);
            $categoryAndSubtreeIds = $getCategoryAndSubtreeIdsAction->execute($category_id);

            $productQuery->forMainAndRelatedCategories($categoryAndSubtreeIds);
        }

        if ($product_name) {
            $productQuery->where(Product::TABLE . ".name", "like", "%{$product_name}%");
        }

        $this->loadedForProductProduct[$for] = collect($productQuery->paginate(20)->items())->map(fn (Product $product) => ProductProductDTO::fromModel($product, "loadedForProductProduct.{$for}.{$product->id}.")->toArray())->keyBy('id')->all();
    }

    protected function saveProductProduct()
    {
        foreach ($this->mapTypeToRelationName as $type => $relation) {
            $currentIds = collect($this->productProducts[$type])
                ->filter(fn (array $item) => ! $item['toDelete'])
                ->pluck('id')
                ->values()
                ->toArray();
            $selectedIds = collect($this->loadedForProductProduct[$type])
                ->filter(fn (array $item) => $item['isSelected'])
                ->pluck('id')
                ->values()
                ->toArray();
            $ids = array_merge($currentIds, $selectedIds);
            $sync = collect($ids)->reduce(function (array $acc, int $id) use ($type) {
                $acc[$id] = ["type" => $type];

                return $acc;
            }, []);
            $this->item->{$relation}()->sync($sync);
        }
        $this->initProductProduct($this->item);
        $this->initLoadedForProductProduct();
        $this->initSearchForProductProduct();
    }

    protected function initProductProduct(Product $product)
    {
        foreach ($this->mapTypeToRelationName as $type => $relation) {
            $product->load("$relation.media");
            /** @var \Illuminate\Support\Collection $rel */
            $rel = $product->{$relation};
            $this->productProducts[$type] = $rel->map(
                fn (Product $productProduct) => ProductProductDTO::fromModel(
                    $productProduct,
                    "productProducts.{$type}.{$productProduct->id}."
                )->toArray()
            )
                ->keyBy('id')
                ->all();
        }
    }

    protected function initLoadedForProductProduct()
    {
        $this->loadedForProductProduct = static::$initLoadedProductProduct;
    }

    protected function initSearchForProductProduct()
    {
        $this->searchForProductProduct = static::$initSearchForProductProduct;
    }
}
