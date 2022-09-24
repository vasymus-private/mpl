<?php

namespace Domain\Products\Actions\CreateOrUpdateBrand;

use Domain\Common\Actions\BaseAction;
use Domain\Products\Actions\SaveSeoAction;
use Domain\Products\Actions\SyncAndSaveMediasAction;
use Domain\Products\DTOs\Admin\Inertia\BrandDTO;
use Domain\Common\DTOs\MediaDTO;
use Domain\Products\Models\Brand;
use Illuminate\Support\Facades\DB;

class CreateOrUpdateBrandAction extends BaseAction
{
    /**
     * @var \Domain\Products\Actions\SaveSeoAction
     */
    private SaveSeoAction $saveSeoAction;

    /**
     * @var \Domain\Products\Actions\SyncAndSaveMediasAction
     */
    private SyncAndSaveMediasAction $syncAndSaveMediasAction;

    /**
     * @param \Domain\Products\Actions\SaveSeoAction $saveSeoAction
     * @param \Domain\Products\Actions\SyncAndSaveMediasAction $syncAndSaveMediasAction
     */
    public function __construct(
        SaveSeoAction $saveSeoAction,
        SyncAndSaveMediasAction $syncAndSaveMediasAction
    ) {
        $this->saveSeoAction = $saveSeoAction;
        $this->syncAndSaveMediasAction = $syncAndSaveMediasAction;
    }

    /**
     * @param \Domain\Products\DTOs\Admin\Inertia\BrandDTO $brandDTO
     * @param \Domain\Products\Models\Brand|null $target
     *
     * @return \Domain\Products\Models\Brand
     */
    public function execute(BrandDTO $brandDTO, Brand $target = null): Brand
    {
        return DB::transaction(function () use ($brandDTO, $target) {
            $target = $target ?: new Brand();

            if ($brandDTO->name !== null) {
                $target->name = $brandDTO->name;
            }

            if ($brandDTO->slug !== null) {
                $target->slug = $brandDTO->slug;
            }

            if ($brandDTO->ordering !== null) {
                $target->ordering = $brandDTO->ordering;
            }

            if ($brandDTO->preview !== null) {
                $target->preview = $brandDTO->preview;
            }

            if ($brandDTO->description !== null) {
                $target->description = $brandDTO->description;
            }

            if (! $target->id) {
                $target->save();
            }

            $this->saveMainImage($target, $brandDTO->mainImage);

            $this->saveSeoAction->execute($target, $brandDTO->seo);

            $target->save();

            return $target;
        });
    }

    /**
     * @param \Domain\Products\Models\Brand $target
     * @param \Domain\Common\DTOs\MediaDTO|null $mediaDTO
     *
     * @return void
     */
    private function saveMainImage(Brand $target, MediaDTO $mediaDTO = null)
    {
        $this->syncAndSaveMediasAction->execute($target, $mediaDTO ? [ $mediaDTO ] : [], Brand::MC_MAIN_IMAGE);
    }
}
