<?php
/**
 * @var string $currentRoute
 * @var string $newRoute
 * @var string|int|null $category_id
 * @var string|int|null $category_name
 */
?>
<form wire:submit.prevent="submit" method="GET">
    <div class="search form-group row">
        <div class="col-xs-12 col-sm-10">
            <div class="input-group mb-3">
                @if($category_id)
                    <div class="input-group-prepend">
                        <span style="max-width: 200px;" class="input-group-text d-inline-block text-truncate">{{$category_name}}</span>
                        <button wire:click.prevent="clearPrepend" class="btn btn-light" type="button" id="button-addon1"><i class="fa fa-times" aria-hidden="true"></i></button>
                    </div>
                @endif
                <input wire:model="search" type="text" class="form-control" placeholder="Фильтр + поиск" aria-label="Фильтр + поиск" aria-describedby="search-button">
                <div class="input-group-append">
                    <button wire:click.prevent="clearAll" class="btn-outline-secondary" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
                    <button class="btn-outline-secondary search-icon" type="submit" id="search-button"><i class="fa fa-search" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-2">
            <div class="dropdown">
                <a href="#" wire:click.prevent="newItem" class="btn btn-add btn-secondary">Создать</a>
            </div>
        </div>
    </div>
</form>
