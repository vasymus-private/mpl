<?php

namespace App\Http\Livewire\Admin\ShowProduct;

use App\Http\Livewire\Admin\HasSeo;
use Domain\Products\Models\Product\Product;

class Seo extends BaseShowProduct
{
    use HasSeo;

    /**
     * @return array
     */
    protected function queryString(): array
    {
        return array_merge($this->getHasShowProductQueryString(), []);
    }

    /**
     * @return array
     */
    protected function rules(): array
    {
        return array_merge($this->getSeoRules(), []);
    }

    public function mount()
    {
//        dump($this->item->uuid);
        $this->initCommonShowProduct();

        $this->initItem();
    }

    public function render()
    {
        return view('admin.livewire.show-product.seo');
    }

    protected function initItem()
    {
        if ($this->isCreatingFromCopy) {
            $copyProduct = $this->getCopyProduct();
            if ($copyProduct !== null) {
                $this->initAsCopiedItem($copyProduct);
                return;
            }
        }

        $this->initSeo();
    }

    protected function initAsCopiedItem(Product $origin)
    {
        parent::initAsCopiedItem($origin);

        // seo
        $seo = $origin->seo ?: new \Domain\Seo\Models\Seo();
        $seo->seoable_id = null;
        $seo->seoable_type = null;
        $this->seo = $seo;
    }

    public function handleSave()
    {
        $this->validateBeforeHandleSave();
        $this->getRefreshedItemOrNew();

        $this->saveSeo();
    }

    protected function getComponentName(): string
    {
        return ShowProductConstants::COMPONENT_NAME_SEO;
    }

}
