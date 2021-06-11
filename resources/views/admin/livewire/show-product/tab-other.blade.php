<?php
/**
 * @var array[] $categories @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Products\Models\Category}
 * @see {@link \App\Http\Livewire\Admin\ShowProduct::$relatedCategories}
 * @see {@link \App\Http\Livewire\Admin\ShowProduct::$item}
 */
?>

@foreach($categories as $category)
    <div class="row">
        <div class="form-check form-check-inline">
            <input wire:model.defer="item.category_id" class="form-check-input" type="radio" name="main-category" value="{{$category['value']}}" />
            <input wire:model.defer="relatedCategories" class="form-check-input" type="checkbox" value="{{$category['value']}}" id="related-category-{{$category['value']}}" />
            <label for="related-category-{{$category['value']}}" class="form-check-label">@if($category['isHtmlString']) {!! $category['label'] !!} @else {{$category['label']}} @endif</label>
        </div>
    </div>
@endforeach
