<?php
/**
 * @var array[] $items @see {@link \Domain\Products\DTOs\Admin\CategoryItemDTO}
 * @var string|int|null $category_id
 * @var string|int|null $category_name
 * @var bool $editMode
 * @var \App\Http\Livewire\Admin\CategoriesList $this
 */
?>
<div x-data="{
        items: @entangle('items').defer,
        editMode: @entangle('editMode'),
        selectAll: @entangle('selectAll')
    }"
     x-init="
        Livewire.hook('message.processed', (message, component) => {
            [...$el.querySelectorAll('.js-product-item-checkbox')].forEach(e => {
                let uuid = e.dataset['itemId'];
                let item = component.$wire.items[uuid];
                if (item) {
                    e.checked = item.is_checked;
                }
            })
        })
    ">
    @include('admin.livewire.includes.form-search', [
        'submit' => 'handleSearch',
        'newRoute' => route('admin.categories.create'),
        'clearAll' => 'clearAllFilters',
        'prepends' => $this->getPrepends(),
    ])

    <div class="admin-edit-variations">
        <div wire:loading.flex>
            <div class="d-flex justify-content-center align-items-center bg-light" style="opacity: 0.5; position:absolute; top:0; bottom:0; right:0; left:0; z-index: 20; ">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col">
                        <div class="form-check form-check-inline no-padding-top">
                            <input
                                x-bind:disabled="editMode"
                                x-model="selectAll"
                                class="form-check-input position-static"
                                type="checkbox">
                        </div>
                    </th>
                    <th scope="col">&nbsp;</th>
                    <th scope="col">ID</th>
                    <th scope="col">Название</th>
                    <th scope="col">Сортировка</th>
                    <th scope="col">Активность</th>
                </tr>
            </thead>
            <tbody>
            @foreach($items as $category)
                <tr class="js-product-item" wire:key="product-{{$category['id']}}">
                    <td
                        data-item-id="{{$category['id']}}"
                        @click="
                            if(!editMode && items[$el.dataset['itemId']]) {
                                let isChecked = items[$el.dataset['itemId']].is_checked;
                                items[$el.dataset['itemId']].is_checked = !isChecked;
                                $el.querySelector('input').checked = !isChecked;
                            }
                        ">
                        <div class="form-check">
                            <input
                                data-item-id="{{$category['id']}}"
                                @click.stop="$el.closest('td').click()"
                                x-bind:disabled="editMode"
                                class="form-check-input position-static js-product-item-checkbox"
                                type="checkbox">
                        </div>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn__grid-row-action-button" type="button" id="actions-dropdown-{{$category['id']}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                            <div class="dropdown-menu bx-core-popup-menu" aria-labelledby="actions-dropdown-{{$category['id']}}">
                                <div class="bx-core-popup-menu__arrow"></div>
                                <a class="bx-core-popup-menu-item bx-core-popup-menu-item-default" href="{{route("admin.products.index", ['category_id' => $category['id']])}}">
                                    <span class="bx-core-popup-menu-item-icon"></span>
                                    <span class="bx-core-popup-menu-item-text">Товары</span>
                                </a>
                                <a class="bx-core-popup-menu-item bx-core-popup-menu-item-default" href="{{route("admin.categories.edit", $category['id'])}}">
                                    <span class="bx-core-popup-menu-item-icon adm-menu-edit"></span>
                                    <span class="bx-core-popup-menu-item-text">Изменить</span>
                                </a>
                                <button type="button" class="bx-core-popup-menu-item" wire:click="toggleActive({{$category['id']}})">
                                    <span class="bx-core-popup-menu-item-icon"></span>
                                    <span class="bx-core-popup-menu-item-text">
                                        @if($category['is_active'])
                                            Деактивировать
                                        @else
                                            Активировать
                                        @endif
                                    </span>
                                </button>
                                <button type="button" class="bx-core-popup-menu-item" onclick="@this.handleDelete({{$category['id']}}).then(res => console.log(res))">
                                    <span class="bx-core-popup-menu-item-icon adm-menu-delete"></span>
                                    <span class="bx-core-popup-menu-item-text">Удалить</span>
                                </button>
                            </div>
                        </div>
                    </td>
                    <td><span class="main-grid-cell-content">{{$category['id']}}</span></td>
                    <td>
                        @if($editMode && $category['is_checked'])
                            @include('admin.livewire.includes.form-control-input', ['field' => "items.{$category['id']}.name", 'modifier' => '.defer'])
                        @else
                            <span class="main-grid-cell-content">
                                <a href="#" wire:click.prevent="navigate({{$category['id']}})" class="table__column-name">
                                    <span class="adm-submenu-item-link-icon adm-list-table-icon iblock-section-icon"></span>
                                    {!! $category['name'] !!}
                                </a>
                            </span>
                        @endif
                    </td>
                    <td @if($editMode && $category['is_checked']) style="width: 200px;" @endif>
                        @if($editMode && $category['is_checked'])
                            @include('admin.livewire.includes.form-control-input', ['field' => "items.{$category['id']}.ordering", 'modifier' => '.defer'])
                        @else
                            <span class="main-grid-cell-content">{{$category['ordering']}}</span>
                        @endif
                    </td>
                    <td>
                        @if($editMode && $category['is_checked'])
                            @include('admin.livewire.includes.form-check', ['field' => "items.{$category['id']}.is_active", 'modifier' => '.defer'])
                        @else
                            <span class="main-grid-cell-content">{{$category['is_active_name']}}</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <footer class="footer edit-item-footer">
        @if(!$editMode)
            <button wire:click.prevent="$set('editMode', true)" x-bind:disabled="!Object.values(items).some(item => item.is_checked)" type="button" class="btn btn-primary mb-2 btn__save mr-2">Редактировать</button>
            <button x-bind:disabled="!Object.values(items).some(item => item.is_checked)" onclick="@this.deleteSelected().then(res => console.log(res))" type="button" class="btn btn-info mb-2 btn__default">Удалить</button>
        @else
            <button wire:click.prevent="saveSelected" type="button" class="btn btn-info">Сохранить</button>
            <button @click="$wire.cancelEdit()" type="button" class="btn btn-warning">Отменить</button>
        @endif
        @foreach($errors->all() as $error)
            <div wire:key="{{$error}}" class="alert alert-danger alert-dismissible fade show" role="alert">
                {{$error}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endforeach
    </footer>
</div>
