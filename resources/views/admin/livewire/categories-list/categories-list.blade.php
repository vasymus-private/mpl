<?php
/**
 * @var array[] $categories @see {@link \Domain\Products\DTOs\ProductItemAdminDTO[]}
 * @var string|int|null $category_id
 * @var string|int|null $category_name
 * @var bool $editMode
 * @var \App\Http\Livewire\Admin\CategoriesList $this
 */
?>
<div>
    @include('admin.livewire.includes.form-search', [
        'submit' => 'handleSearch',
        'newRoute' => route('admin.categories.create'),
        'clearAll' => 'clearAllFilters',
        'prepends' => $this->getPrepends(),
    ])

    <div class="table-responsive position-relative">
        <div wire:loading.flex>
            <div class="d-flex justify-content-center align-items-center bg-light" style="opacity: 0.5; position:absolute; top:0; bottom:0; right:0; left:0; z-index: 20; ">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>

        <table class="table">
            <thead class="thead-light">
            <tr>
                <th scope="col">
                    <div class="form-check">
                        <input wire:model="selectAll" @if($editMode) disabled @endif class="form-check-input position-static" type="checkbox">
                    </div>
                </th>
                <th scope="col"><span class="main-grid-head-title">&nbsp;</span></th>
                <th scope="col"><span class="main-grid-head-title">ID</span></th>
                <th scope="col"><span class="main-grid-head-title">Название</span></th>
                <th scope="col"><span class="main-grid-head-title">Сортировка</span></th>
                <th scope="col"><span class="main-grid-head-title">Активность</span></th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr class="js-product-item" wire:key="product-{{$category['id']}}">
                    <td>
                        <div class="form-check">
                            <input wire:model.defer="categories.{{$category['id']}}.is_checked" @if($editMode) disabled @endif class="form-check-input position-static" type="checkbox">
                        </div>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary" type="button" id="actions-dropdown-{{$category['id']}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bars"></i></button>
                            <div class="dropdown-menu" aria-labelledby="actions-dropdown-{{$category['id']}}">
                                <a class="dropdown-item" href="{{route("admin.products.edit", $category['id'])}}">Изменить</a>
                                <button type="button" class="dropdown-item btn btn-link" wire:click="toggleActive({{$category['id']}})">
                                    @if($category['is_active'])
                                        Деактивировать
                                    @else
                                        Активировать
                                    @endif
                                </button>
                                <a class="dropdown-item" href="#">Копировать</a>
                                <button type="button" class="dropdown-item btn btn-link" onclick="@this.handleDelete({{$category['id']}}).then(res => console.log(res))">Удалить</button>
                            </div>
                        </div>
                    </td>
                    <td><span class="main-grid-cell-content">{{$category['id']}}</span></td>
                    <td>
                        @if($editMode && $category['is_checked'])
                            @include('admin.livewire.includes.form-control-input', ['field' => "categories.{$category['id']}.name"])
                        @else
                            <span class="main-grid-cell-content"><a href="#" wire:click.prevent="navigate({{$category['id']}})"><i class="fa fa-folder" aria-hidden="true"></i> {!! $category['name'] !!}</a></span>
                        @endif
                    </td>
                    <td @if($editMode && $category['is_checked']) style="width: 200px;" @endif>
                        @if($editMode && $category['is_checked'])
                            @include('admin.livewire.includes.form-control-input', ['field' => "categories.{$category['id']}.ordering"])
                        @else
                            <span class="main-grid-cell-content">{{$category['ordering']}}</span>
                        @endif
                    </td>
                    <td>
                        @if($editMode && $category['is_checked'])
                            @include('admin.livewire.includes.form-check', ['field' => "categories.{$category['id']}.is_active"])
                        @else
                            <span class="main-grid-cell-content">{{$category['is_active_name']}}</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="row pb-5">
        @if(!$editMode)
            <div class="col-sm-3" wire:key="edit-btn">
                <button wire:click.prevent="$set('editMode', true)" type="button" class="btn btn-light"><i class="fa fa-edit"></i> Редактировать</button>
            </div>
            <div class="col-sm-3" wire:key="delete-btn">
                <button onclick="@this.deleteSelected().then(res => console.log(res))" type="button" class="btn btn-light"><i class="fa fa-times"></i> Удалить</button>
            </div>
        @else
            <div class="col-sm-3" wire:key="save-btn">
                <button wire:click.prevent="saveSelected" type="button" class="btn btn-info">Сохранить</button>
            </div>
            <div class="col-sm-3" wire:key="cancel-btn">
                <button wire:click.prevent="cancelEdit" type="button" class="btn btn-warning">Отменить</button>
            </div>
        @endif
    </div>
</div>
