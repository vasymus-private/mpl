<?php
/**
 * @var array[] $charCategories @see {@link \Domain\Products\DTOs\Admin\CharCategoryDTO}
 * @var array[] $charRateOptions @see {@link \Domain\Common\DTOs\OptionDTO}
 */
?>

@foreach($charCategories as $index => $charCategory)
    <div wire:key="{{sprintf('char-categories-%s-%s', $index, $charCategory['id'])}}" class="mb-5">
        <h3 class="h5">
            <button @if($loop->first) disabled @endif type="button" wire:click="charCategoryOrdering({{$index}}, true)" class="btn btn-info mx-1">&uarr;</button>
            <button @if($loop->last) disabled @endif type="button" wire:click="charCategoryOrdering({{$index}}, false)" class="btn btn-info mx-1">&darr;</button>
            {{$charCategory['name']}}
            <button onclick="if(confirm('Удалить заголовок и все его характеристики?')) @this.deleteCharCategory({{$index}})" type="button" class="btn btn-danger mx-1">x</button>
        </h3>

        <div style="padding-left: 50px;">
            @foreach($charCategory['chars'] as $charIndex => $char)
                <?php /** @var array $char @see {@link \Domain\Products\DTOs\Admin\CharDTO} */ ?>
                <div wire:key="{{sprintf('char-%s-%s', $charIndex, $char['id'])}}" class="form-group row">
                    <div class="col-sm-7 d-flex">
                        <div>
                            <button @if($loop->first) disabled @endif type="button" wire:click="charOrdering({{$index}}, {{$charIndex}}, true)" class="btn btn-info mx-1">&uarr;</button>
                            <button @if($loop->last) disabled @endif type="button" wire:click="charOrdering({{$index}}, {{$charIndex}}, false)" class="btn btn-info mx-1">&darr;</button>
                            <label for="{{sprintf('charCategories.%s.chars.%s.value', $index, $charIndex)}}">{{$char['name']}}:</label>
                            <button wire:click="deleteChar({{$index}}, {{$charIndex}})" type="button" class="btn btn-danger mx-1">x</button>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        @if($char['is_rate'])
                            @include('admin.livewire.includes.form-control-select', [
                                'field' => sprintf('charCategories.%s.chars.%s.value', $index, $charIndex),
                                 'options' => $charRateOptions,
                             ])
                        @else
                            @include('admin.livewire.includes.form-control-input', [
                                'field' => sprintf('charCategories.%s.chars.%s.value', $index, $charIndex),
                            ])
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endforeach

<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-char">+ Добавить характеристику</button>
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-char-category">+ Добавить заголовок для характеристик</button>

<!-- Modals -->
<div class="modal fade" id="add-char" tabindex="-1" aria-labelledby="add-char-title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-char-title">Добавление новой характеристики</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Выбрать заголовок характеристики:</label>
                    <div class="col-sm-9">
                        <select class="form-control">
                            <option value="">(не установлено)</option>
                            <option value="">Описание товара</option>
                            <option value="">Технические детали</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tl" class="col-sm-3 col-form-label">Название характерстики:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="tl">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Тип поля ввода:</label>
                    <div class="col-sm-9">
                        <select class="form-control" >
                            <option value="">Текстовое</option>
                            <option value="">Рейтинг</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary">Добавить</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add-char-category" tabindex="-1" aria-labelledby="add-char-category-title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-char-category-title">Добавление нового заголовка для характеристик</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('admin.livewire.includes.form-group-input', ['field' => 'newCharCategory.name'])
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button wire:click="addNewCharCategory" type="button" class="btn btn-primary">Добавить</button>
            </div>
        </div>
    </div>
</div>
