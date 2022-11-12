<?php
/**
 * @var array[] $charCategories @see {@link \Domain\Products\DTOs\Admin\CharCategoryDTO}
 * @var array[] $charRateOptions @see {@link \Domain\Common\DTOs\OptionDTO}
 * @var \App\Http\Livewire\Admin\ShowProduct\ShowProduct $this
 */
?>

<div class="item-edit product-edit">
    @foreach($charCategories as $index => $charCategory)
        <div wire:key="{{sprintf('char-categories-%s-%s', $index, $charCategory['id'])}}" class="mb-5 characteristics">
            <div class="row-line title-row-bg">
                <div class="buttons-block">
                    <button @if($loop->first) disabled @endif type="button" wire:click="charCategoryOrdering({{$index}}, true)" class="btn btn__default">&uarr;</button>
                    <button @if($loop->last) disabled @endif type="button" wire:click="charCategoryOrdering({{$index}}, false)" class="btn btn__default">&darr;</button>
                </div>
                <h4 class="title">{{$charCategory['name']}}</h4>
                <button onclick="if(confirm('Удалить заголовок и все его характеристики?')) @this.deleteCharCategory({{$index}})" type="button" class="btn btn__remove">x</button>
            </div>
            @foreach($charCategory['chars'] as $charIndex => $char)
                <?php /** @var array $char @see {@link \Domain\Products\DTOs\Admin\CharDTO} */ ?>
                <div wire:key="{{sprintf('char-%s-%s', $charIndex, $char['id'])}}" class="row-line">
                    <div class="column">
                        <div class="buttons-block">
                            <button @if($loop->first) disabled @endif type="button" wire:click="charOrdering({{$index}}, {{$charIndex}}, true)" class="btn btn__default">&uarr;</button>
                            <button @if($loop->last) disabled @endif type="button" wire:click="charOrdering({{$index}}, {{$charIndex}}, false)" class="btn btn__default">&darr;</button>
                        </div>
                        <label for="{{sprintf('charCategories.%s.chars.%s.value', $index, $charIndex)}}">{{$char['name']}}:</label>
                    </div>
                    <div class="column between">
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
                        <button wire:click="deleteChar({{$index}}, {{$charIndex}})" type="button" class="btn btn__remove">x</button>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach

    @if($this->isCreatingFromCopy)
        <p class="text-danger">Чтобы добавлять новые характеристики, необходимо сохранить скопированный товар.</p>
    @else
        <div class="row-buttons">
            <button type="button" class="btn btn__add" data-toggle="modal" data-target="#add-char-category">Добавить заголовок</button>
        </div>
        <div class="row-buttons">
            <button type="button" class="btn btn__add" data-toggle="modal" data-target="#add-char">Добавить характеристику</button>
        </div>
        <!-- Modals -->
        <div wire:ignore.self class="modal fade" id="add-char" tabindex="-1" aria-labelledby="add-char-title" aria-hidden="true">
            <div class="modal-dialog">
                @include('admin.livewire.includes.loading', ['target' => 'addNewChar'])
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="add-char-title">Добавление новой характеристики</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @include('admin.livewire.includes.form-group-select', [
                            'field' => 'newChar.category_id',
                            'options' => $this->getCharCategoryOptions(),
                            'label' => 'Выбрать заголовок характеристики',
                        ])

                        @include('admin.livewire.includes.form-group-input', ['field' => 'newChar.name', 'label' => 'Название'])

                        @include('admin.livewire.includes.form-group-select', [
                            'field' => 'newChar.type_id',
                            'options' => $charTypes,
                            'label' => 'Тип поля ввода',
                        ])
                    </div>
                    <div class="modal-footer">
                        <button onclick="@this.addNewChar().then((res) => { if(res) $('#add-char').modal('hide') })" type="button" class="btn btn__default">Добавить</button>
                    </div>
                </div>
            </div>
        </div>

        <div wire:ignore.self class="modal fade" id="add-char-category" tabindex="-1" aria-labelledby="add-char-category-title" aria-hidden="true">
            <div class="modal-dialog">
                @include('admin.livewire.includes.loading', ['target' => 'addNewCharCategory'])
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="add-char-category-title">Добавление нового заголовка для характеристик</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @include('admin.livewire.includes.form-group-input', ['field' => 'newCharCategory.name', 'label' => 'Название'])
                    </div>
                    <div class="modal-footer">
                        <button onclick="@this.addNewCharCategory().then((res) => {if(res) $('#add-char-category').modal('hide') })" type="button" class="btn btn__default">Добавить</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
