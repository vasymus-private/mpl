<?php

namespace Domain\Products\Actions\CreateOrUpdateProduct;

use Domain\Common\Actions\BaseAction;
use Domain\Products\Models\InformationalPrice;
use Domain\Products\Models\Product\Product;

class SyncAndSaveInfoPricesAction extends BaseAction
{
    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\InfoPriceDTO[] $infoPriceDTOs
     *
     * @return void
     */
    public function execute(Product $target, array $infoPriceDTOs)
    {
        if (! $target->id) {
            $target->save();
        }

        $infoPricesIds = collect($infoPriceDTOs)->pluck('id')->filter(fn ($id) => (bool)$id)->toArray();
        $target
            ->infoPrices()
            ->whereNotIn('id', $infoPricesIds)
            ->delete();

        foreach ($infoPriceDTOs as $infoPriceDTO) {
            /** @var \Domain\Products\Models\InformationalPrice $infoPriceModel */
            $infoPriceModel = InformationalPrice::query()->findOrNew($infoPriceDTO->id);
            $infoPriceModel->name = $infoPriceDTO->name;
            $infoPriceModel->price = $infoPriceDTO->price;
            $infoPriceModel->product_id = $target->id;
            $infoPriceModel->save();
        }
    }
}
