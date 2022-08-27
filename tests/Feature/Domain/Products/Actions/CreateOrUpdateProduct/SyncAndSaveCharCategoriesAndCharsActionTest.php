<?php

namespace Tests\Feature\Domain\Products\Actions\CreateOrUpdateProduct;

use Database\Factories\ProductFactory;
use Domain\Products\Actions\CreateOrUpdateProduct\SyncAndSaveCharCategoriesAndCharsAction;
use Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharCategoryDTO;
use Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharDTO;
use Tests\Feature\BaseActionTestCase;

class SyncAndSaveCharCategoriesAndCharsActionTest extends BaseActionTestCase
{
    protected const TEST_CHAR_CATEGORY_NAME = 'hello';
    protected const TEST_CHAR_CATEGORY_NAME_2 = 'hello2';
    protected const TEST_CHAR_CATEGORY_ORDERING = 100;
    protected const TEST_CHAR_CATEGORY_ORDERING_2 = 1000;
    protected const TEST_CHAR_NAME = 'world';
    protected const TEST_CHAR_VALUE = 1;
    protected const TEST_CHAR_VALUE_2 = 'ddd';

    /**
     * @return void
     */
    public function testCharCategoriesCreatedSuccessfully()
    {
        /** @var \Domain\Products\Models\Product\Product $product */
        $product = ProductFactory::new()->create();
        $charCategoryDTO = $this->getTestCharCategoryDTO([
            'name' => static::TEST_CHAR_CATEGORY_NAME,
            'ordering' => static::TEST_CHAR_CATEGORY_ORDERING,
            'chars' => [
                [
                    'name' => static::TEST_CHAR_NAME,
                    'value' => static::TEST_CHAR_VALUE,
                ]
            ]
        ]);

        SyncAndSaveCharCategoriesAndCharsAction::cached()->execute($product, [$charCategoryDTO]);

        $product->load('charCategories.chars');
        $this->assertEquals(1, $product->charCategories->count());
        /** @var \Domain\Products\Models\CharCategory $charCategory */
        $charCategory = $product->charCategories->first();
        $this->assertEquals(static::TEST_CHAR_CATEGORY_NAME, $charCategory->name);
        $this->assertEquals(static::TEST_CHAR_CATEGORY_ORDERING, $charCategory->ordering);
        $this->assertEquals(1, $charCategory->chars->count());
        /** @var \Domain\Products\Models\Char $char */
        $char = $charCategory->chars->first();
        $this->assertEquals(static::TEST_CHAR_NAME, $char->name);
        $this->assertEquals(static::TEST_CHAR_VALUE, $char->value);
    }

    /**
     * @return void
     */
    public function testCharCategoriesUpdatedSuccessfully()
    {
        /** @var \Domain\Products\Models\Product\Product $product */
        $product = ProductFactory::new()->create();
        $charCategoryDTO = $this->getTestCharCategoryDTO();
        SyncAndSaveCharCategoriesAndCharsAction::cached()->execute($product, [$charCategoryDTO]);

        $product->load('charCategories.chars');
        /** @var \Domain\Products\Models\CharCategory $createdCharCategory */
        $createdCharCategory = $product->charCategories->first();
        /** @var \Domain\Products\Models\Char $createdChar */
        $createdChar = $createdCharCategory->chars->first();

        $charCategoryDTO->id = $createdCharCategory->id;
        $charCategoryDTO->name = static::TEST_CHAR_CATEGORY_NAME_2;
        $charCategoryDTO->ordering = static::TEST_CHAR_CATEGORY_ORDERING_2;

        $charCategoryDTO->chars = [
            new CharDTO([
                'id' => $createdChar->id,
                'name' => $createdChar->name,
                'value' => static::TEST_CHAR_VALUE_2,
            ])
        ];
        SyncAndSaveCharCategoriesAndCharsAction::cached()->execute($product, [$charCategoryDTO]);

        $product->load('charCategories.chars');
        $this->assertEquals(1, $product->charCategories->count());

        /** @var \Domain\Products\Models\CharCategory $updatedCharCategory */
        $updatedCharCategory = $product->charCategories->first();
        $this->assertEquals(1, $updatedCharCategory->chars->count());
        $this->assertEquals(static::TEST_CHAR_CATEGORY_NAME_2, $updatedCharCategory->name);
        $this->assertEquals(static::TEST_CHAR_CATEGORY_ORDERING_2, $updatedCharCategory->ordering);

        /** @var \Domain\Products\Models\Char $updatedChar */
        $updatedChar = $updatedCharCategory->chars->first();
        $this->assertEquals($createdChar->id, $updatedChar->id);
        $this->assertEquals(static::TEST_CHAR_VALUE_2, $updatedChar->value);
    }

    public function testCharCategoryCopiedSuccessfully()
    {
        /** @var \Domain\Products\Models\Product\Product $product */
        $product = ProductFactory::new()->create();
        $charCategoryDTO = $this->getTestCharCategoryDTO();
        SyncAndSaveCharCategoriesAndCharsAction::cached()->execute($product, [$charCategoryDTO]);

        $product->load('charCategories.chars');
        /** @var \Domain\Products\Models\CharCategory $createdCharCategory */
        $createdCharCategory = $product->charCategories->first();
        /** @var \Domain\Products\Models\Char $createdChar */
        $createdChar = $createdCharCategory->chars->first();

        /** @var \Domain\Products\Models\Product\Product $newProduct */
        $newProduct = ProductFactory::new()->create();
        $charCategoryDTO->id = $createdCharCategory->id;
        $charCategoryDTO->chars = [
            new CharDTO([
                'id' => $createdChar->id,
                'name' => $createdChar->name,
                'value' => $createdChar->value,
            ])
        ];
        SyncAndSaveCharCategoriesAndCharsAction::cached()->execute($newProduct, [$charCategoryDTO]);
        $product->load('charCategories.chars');
        $newProduct->load('charCategories.chars');

        $this->assertEquals(1, $product->charCategories->count());
        $this->assertEquals(1, $newProduct->charCategories->count());

        /** @var \Domain\Products\Models\CharCategory $originalCharCategory */
        $originalCharCategory = $product->charCategories->first();
        /** @var \Domain\Products\Models\CharCategory $copiedCharCategory */
        $copiedCharCategory = $newProduct->charCategories->first();

        $this->assertEquals($originalCharCategory->name, $copiedCharCategory->name);
        $this->assertEquals(1, $originalCharCategory->chars->count());
        $this->assertEquals(1, $copiedCharCategory->chars->count());

        /** @var \Domain\Products\Models\Char $originalChar */
        $originalChar = $originalCharCategory->chars->first();
        /** @var \Domain\Products\Models\Char $copiedChar */
        $copiedChar = $copiedCharCategory->chars->first();
        $this->assertEquals($originalChar->name, $copiedChar->name);
        $this->assertEquals($originalChar->value, $copiedChar->value);
    }

    /**
     * @param array $attributes
     *
     * @return \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharCategoryDTO
     */
    protected function getTestCharCategoryDTO(array $attributes = []): CharCategoryDTO
    {
        return new CharCategoryDTO([
            'name' => $attributes['name'] ?? 'foo',
            'ordering' => $attributes['ordering'] ?? 10,
            'chars' => [
                new CharDTO([
                    'name' => $attributes['chars'][0]['name'] ?? 'bar',
                    'value' => $attributes['chars'][0]['value'] ?? 'baz',
                ])
            ]
        ]);
    }
}
