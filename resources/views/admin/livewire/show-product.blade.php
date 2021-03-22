<?php /** @var \Domain\Products\Models\Product\Product $product */ ?>
<div>
    <ul class="nav nav-tabs" id="show-product-tabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="elements-tab" data-toggle="tab" href="#elements" role="tab" aria-controls="elements" aria-selected="true">Элемент</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="false">Описание</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="photo-tab" data-toggle="tab" href="#photo" role="tab" aria-controls="photo" aria-selected="false">Фото</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="characteristics-tab" data-toggle="tab" href="#characteristics" role="tab" aria-controls="characteristics" aria-selected="false">Характеристики</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="seo-tab" data-toggle="tab" href="#seo" role="tab" aria-controls="seo" aria-selected="false">SEO</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="accessories-tab" data-toggle="tab" href="#accessories" role="tab" aria-controls="accessories" aria-selected="false">Аксессуары</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="similar-tab" data-toggle="tab" href="#similar" role="tab" aria-controls="similar" aria-selected="false">Похожие</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="related-tab" data-toggle="tab" href="#related" role="tab" aria-controls="related" aria-selected="false">Сопряжённые</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="works-tab" data-toggle="tab" href="#works" role="tab" aria-controls="works" aria-selected="false">Работы</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="variations-tab" data-toggle="tab" href="#variations" role="tab" aria-controls="variations" aria-selected="false">Варианты</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="other-tab" data-toggle="tab" href="#other" role="tab" aria-controls="other" aria-selected="false">Прочее</a>
        </li>
    </ul>
    <div class="tab-content" id="show-product-tab-content">
        <div class="tab-pane fade show active p-3" id="elements" role="tabpanel" aria-labelledby="elements-tab">
            <form wire:submit.prevent="save">

                <div class="form-group row">
                    <div class="col-sm-2">
                        <label class="form-check-label" for="activity">
                            Активность
                        </label>
                    </div>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input wire:model="product.is_active" class="form-check-input" type="checkbox" id="activity">
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Название:</label>
                    <div class="col-sm-10">
                        <input wire:model="product.name" type="text" class="form-control" id="name">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="slug" class="col-sm-2 col-form-label">Символьный код:</label>
                    <div class="col-sm-10">
                        <input wire:model="product.slug" type="text" class="form-control" id="slug">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <div class="tab-pane fade" id="description" role="tabpanel" aria-labelledby="description-tab">
            description
        </div>
        <div class="tab-pane fade" id="photo" role="tabpanel" aria-labelledby="photo-tab">
            photo
        </div>
        <div class="tab-pane fade" id="characteristics" role="tabpanel" aria-labelledby="characteristics-tab">
            characteristics
        </div>
        <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
            seo
        </div>
        <div class="tab-pane fade" id="accessories" role="tabpanel" aria-labelledby="accessories-tab">
            accessories
        </div>
        <div class="tab-pane fade" id="similar" role="tabpanel" aria-labelledby="similar-tab">
            similar
        </div>
        <div class="tab-pane fade" id="related" role="tabpanel" aria-labelledby="related-tab">
            related
        </div>
        <div class="tab-pane fade" id="works" role="tabpanel" aria-labelledby="works-tab">
            works
        </div>
        <div class="tab-pane fade" id="variations" role="tabpanel" aria-labelledby="variations-tab">
            variations
        </div>
        <div class="tab-pane fade" id="other" role="tabpanel" aria-labelledby="other-tab">
            other
        </div>
    </div>

</div>
