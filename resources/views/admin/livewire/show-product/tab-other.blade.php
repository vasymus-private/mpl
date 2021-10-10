<?php
/**
 * @var array[] $categories @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Products\Models\Category} {@link \App\Http\Livewire\Admin\ShowProduct\ShowProduct::$categories}
 * @see {@link \App\Http\Livewire\Admin\ShowProduct\ShowProduct::$relatedCategories}
 * @see {@link \App\Http\Livewire\Admin\ShowProduct\ShowProduct::$item}
 */
?>

<div class="item-edit product-edit other-page">
    <div class="row-line">
        <div class="column">
            <span class="other-page__title">Разделы:</span>
        </div>
        <div class="column">
            @foreach($categories as $category)
                <div class="other-page__item">
                    <div class="form-check form-check-inline">
                        <input wire:model="item.category_id" class="form-check-input radio" type="radio" name="main-category" value="{{$category['value']}}" />
                        <label for="related-category-{{$category['value']}}" class="custom-checkbox">
                            <input wire:model="relatedCategories" class="form-check-input" type="checkbox" value="{{$category['value']}}" id="related-category-{{$category['value']}}" />
                            <span class="label">@if($category['isHtmlString']) {!! $category['label'] !!} @else {{$category['label']}} @endif</span>
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
