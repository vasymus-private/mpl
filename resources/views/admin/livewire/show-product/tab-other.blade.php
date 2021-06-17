<?php
/**
 * @var array[] $categories @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Products\Models\Category}
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
                        <input wire:model="item.category_id" class="form-check-input" type="radio" name="main-category" value="{{$category['value']}}" />
                        <input wire:model="relatedCategories" class="form-check-input" type="checkbox" value="{{$category['value']}}" id="related-category-{{$category['value']}}" />
                        <label for="related-category-{{$category['value']}}" class="form-check-label">{{$category['label']}}</label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
