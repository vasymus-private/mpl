<?php

namespace App\View\Components;

use App\Models\Seo;
use Illuminate\View\Component;

class SeoComponent extends Component
{
    /**
     * @var string
     * */
    public $title;

    /**
     * @var string
     * */
    public $keywords;

    /**
     * @var string
     * */
    public $description;

    /**
     * Create a new component instance.
     *
     * @param array|null $seoArr
     *
     * @return void
     */
    public function __construct(array $seoArr = null)
    {
        $appSeo = Seo::appSeo();

        if (is_array($seoArr)) {
            $this->title = $seoArr["title"] ?? $appSeo->title;
            $this->keywords = $seoArr["keywords"] ?? $appSeo->keywords;
            $this->description = $seoArr["description"] ?? $appSeo->description;
        } else {
            $this->title = $appSeo->title;
            $this->keywords = $appSeo->keywords;
            $this->description = $appSeo->description;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('web.components.seo-component');
    }
}
