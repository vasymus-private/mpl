<?php

namespace App\View\Components;

use App\Models\Category;
use App\Models\Product\Product;
use Illuminate\View\Component;

class H1Component extends Component
{
    /**
     * @var string|null
     * */
    public $h1;

    /**
     * Create a new component instance.
     *
     * @param Category|Product|string|null $entity
     *
     * @return void
     */
    public function __construct($entity = null)
    {
        if (null === $entity || gettype($entity) === "string")
            $this->h1 = $entity;
        else
            $this->h1 = $entity->seo->h1 ?? $entity->name ?? null;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('web.components.h1-component');
    }
}
