<?php

namespace App\Http\Livewire\Admin\ShowProduct;

use Domain\Common\Actions\MoveOrderingItemAction;
use Domain\Common\DTOs\OptionDTO;
use Domain\Products\DTOs\Admin\CharCategoryDTO;
use Domain\Products\DTOs\Admin\CharDTO;
use Domain\Products\Models\Char;
use Domain\Products\Models\CharCategory;
use Domain\Products\Models\CharType;
use Domain\Products\Models\Product\Product;
use Illuminate\Validation\Rules\Exists;

trait HasCharacteristicsTab
{
    /**
     * @var array[] @see {@link \Domain\Products\DTOs\Admin\CharCategoryDTO}
     */
    public array $charCategories;

    /**
     * @var array[] @see {@link \Domain\Common\DTOs\OptionDTO}
     */
    public array $charRateOptions;

    protected static array $defaultNewCharCategory = [
        'name' => '',
    ];

    protected static array $defaultNewChar = [
        'name' => '',
        'category_id' => null,
    ];

    /**
     * @var array @see {@link \Domain\Products\DTOs\Admin\CharCategoryDTO}
     */
    public array $newCharCategory = [];

    /**
     * @var array @see {@link \Domain\Products\DTOs\Admin\CharDTO}
     */
    public array $newChar = [];

    /**
     * @var array[] @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Products\Models\CharType}
     */
    public array $charTypes;

    /**
     * @return string[]|array[]
     */
    protected function getCharacteristicsTabRules(): array
    {
        return [
            'charCategories.*.chars.*.value' => 'nullable|max:199',
        ];
    }

    protected function getNewCharCategoryRules(): array
    {
        return [
            'newCharCategory.name' => 'required|string|max:199',
        ];
    }

    protected function getNewCharRules(): array
    {
        return [
            'newChar.name' => 'required|string|max:199',
            'newChar.category_id' => [
                'required',
                (new Exists(CharCategory::TABLE, 'id'))->where('product_id', $this->item->id)
            ],
            'newChar.type_id' => [
                'required',
                (new Exists(CharType::TABLE, 'id'))
            ],
        ];
    }

    protected function initCharacteristicsTab()
    {
        $this->initCharRateOptions();
        $this->initCharTypeOptions();

        $this->initNewCharCategory();
        $this->initNewChar();

        $product = $this->item;

        if ($this->isCreatingFromCopy) {
            $originProduct = $this->getOriginProduct();
            $product = $originProduct ?: $product;
        }

        $this->initChars($product);
    }

    protected function getCharacteristicsAttributes(): array
    {
        return [];
    }

    protected function getCharacteristicsTabAttributes(): array
    {
        return [];
    }

    protected function handleSaveCharacteristicsTab()
    {
        $charsIds = [];
        $charCategoriesIds = [];

        foreach ($this->charCategories as $charCategoryItem) {
            if ($this->isCreatingFromCopy) {
                $charCategory = CharCategory::forceCreate([
                    'name' => $charCategoryItem['name'],
                    'product_id' => $this->item->id,
                    'ordering' => $charCategoryItem['ordering'],
                ]);
            } else {
                $charCategory = CharCategory::query()->findOrFail($charCategoryItem['id']);
                $charCategory->ordering = $charCategoryItem['ordering'];
                $charCategory->save();
            }
            $charCategoriesIds[] = $charCategory->id;

            foreach ($charCategoryItem['chars'] as $charItem) {
                if ($this->isCreatingFromCopy) {
                    $char = Char::forceCreate([
                        'name' => $charItem['name'],
                        'value' => $charItem['value'],
                        'product_id' => $this->item->id,
                        'category_id' => $charCategory->id,
                        'ordering' => $charItem['ordering'],
                        'type_id' => $charItem['type_id'],
                    ]);
                } else {
                    $char = Char::query()->findOrFail($charItem['id']);
                    $char->value = $charItem['value'];
                    $char->ordering = $charItem['ordering'];
                    $char->save();
                }
                $charsIds[] = $char->id;
            }
        }
        $charCategories = $this->item->charCategories()->get();
        $chars = $this->item->chars()->get();

        $chars->each(function(Char $char) use($charsIds) {
            if (!in_array($char->id, $charsIds)) {
                $char->delete();
            }
        });

        $charCategories->each(function(CharCategory $charCategory) use($charCategoriesIds) {
            if (!in_array($charCategory->id, $charCategoriesIds)) {
                $charCategory->delete();
            }
        });
    }

    /**
     * @return array[] @see {@link \Domain\Common\DTOs\OptionDTO}
     */
    public function getCharCategoryOptions(): array
    {
        return collect($this->charCategories)
            ->map(fn(array $charCategory) => (new OptionDTO([
                'value' => $charCategory['id'],
                'label' => $charCategory['name'],
            ]))->toArray())
            ->all();
    }

    protected function initCharRateOptions()
    {
        $this->charRateOptions = collect(OptionDTO::fromItemsArr(range(0, CharType::RATE_SIZE)))->map(fn(OptionDTO $optionDTO) => $optionDTO->toArray())->all();
    }

    protected function initCharTypeOptions()
    {
        $this->charTypes = CharType::query()->get()->map(fn(CharType $charType) => OptionDTO::fromCharType($charType)->toArray())->all();
    }

    protected function initChars(Product $product)
    {
        $initOrdering = CharCategory::DEFAULT_ORDERING;

        $this->charCategories = $product->charCategories
            ->map(function(CharCategory $charCategory) use(&$initOrdering) {
                if ($initOrdering >= $charCategory->ordering) {
                    $charCategory->ordering = $initOrdering = $initOrdering + 100;
                }
                return CharCategoryDTO::fromModel($charCategory)->toArray();
            })
            ->sortBy('ordering')
            ->values()
            ->all();
    }

    public function charCategoryOrdering($index, bool $isUp = true)
    {
        $this->charCategories = MoveOrderingItemAction::cached()->execute($this->charCategories, (int)$index, $isUp);
    }

    public function charOrdering($charCategoryIndex, $index, bool $isUp = true)
    {
        $chars = $this->charCategories[$charCategoryIndex]['chars'] ?? null;
        if (!$chars) {
            $this->skipRender();
            return;
        }
        $chars = MoveOrderingItemAction::cached()->execute($chars, (int)$index, $isUp);
        $this->charCategories[$charCategoryIndex]['chars'] = $chars;
    }

    public function deleteCharCategory($index)
    {
        unset($this->charCategories[$index]);
        $this->charCategories = array_values($this->charCategories);
    }

    public function deleteChar($charCategoryIndex, $index)
    {
        $charCategory = $this->charCategories[$charCategoryIndex];
        if (!$charCategory) {
            $this->skipRender();
            return;
        }
        $chars = $charCategory['chars'];
        unset($chars[$index]);
        $chars = array_values($chars);
        $charCategory['chars'] = $chars;
        $this->charCategories[$charCategoryIndex] = $charCategory;
    }

    public function addNewCharCategory()
    {
        if ($this->isCreatingFromCopy) {
            return;
        }

        $this->validate($this->getNewCharCategoryRules());

        $largestOrdering = max(collect($this->charCategories)->max('ordering'), 0);

        $charCategory = CharCategory::forceCreate([
            'product_id' => $this->item->id,
            'name' => $this->newCharCategory['name'],
            'ordering' => $largestOrdering + 100,
        ]);

        $this->charCategories[] = CharCategoryDTO::fromModel($charCategory)->toArray();
        $this->initNewCharCategory();

        return true;
    }

    public function addNewChar()
    {
        if ($this->isCreatingFromCopy) {
            return;
        }

        $this->validate($this->getNewCharRules());

        $charCategoryId = $this->newChar['category_id'];
        $charCategory = collect($this->charCategories)->first(fn(array $item) => (string)$item['id'] === (string)$charCategoryId);

        if ($charCategory === null) {
            $this->skipRender();
            return;
        }

        $largestOrdering = max(collect($charCategory['chars'])->max('ordering'), 0);

        $char = Char::forceCreate([
            'product_id' => $this->item->id,
            'name' => $this->newChar['name'],
            'ordering' => $largestOrdering + 100,
            'type_id' => (int)$this->newChar['type_id'],
            'category_id' => $charCategoryId,
        ]);

        $charCategory['chars'][] = CharDTO::fromModel($char)->toArray();
        $this->initNewChar();
        foreach ($this->charCategories as $index => $item) {
            if ((string)$item['id'] === (string)$charCategoryId) {
                $this->charCategories[$index] = $charCategory;
                break;
            }
        }

        return true;
    }

    protected function initNewCharCategory()
    {
        $this->newCharCategory = static::$defaultNewCharCategory;
    }

    protected function initNewChar()
    {
        $this->newChar = static::$defaultNewChar;
    }
}
