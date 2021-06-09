<?php
/**
 * @var array[] $products @see {@link \Domain\Products\DTOs\ProductItemAdminDTO[]}
 * @var \Illuminate\Pagination\LengthAwarePaginator $paginator
 * @var string|int|null $category_id
 * @var string|int|null $category_name
 * @var string|int|null $brand_id
 * @var string|int|null $brand_name
 * @var string|int $total
 * @var array[] $per_page_options @see {@link \Domain\Common\DTOs\OptionDTO[]}
 * @var array[] $brands @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Products\Models\Brand}
 * @var bool $editMode
 * @var array[] $currencies @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Common\Models\Currency}
 * @var array[] $availabilityStatuses @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Products\Models\AvailabilityStatus}
 * @var \App\Http\Livewire\Admin\ProductsList $this
 */
?>
<div>
    @include('admin.livewire.includes.form-search', [
        'submit' => 'handleSearch',
        'newRoute' => route('admin.products.create'),
        'clearAll' => 'clearAllFilters',
        'prepends' => $this->getPrepends(),
        'brandFilter' => true,
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
                <th scope="col"><span class="main-grid-head-title">Сортировка</span></th>
                <th scope="col"><span class="main-grid-head-title">Название</span></th>
                <th scope="col"><span class="main-grid-head-title">Активность</span></th>
                <th scope="col"><span class="main-grid-head-title">Упаковка</span></th>
                <th scope="col"><span class="main-grid-head-title">Закупочная</span></th>
                <th scope="col"><span class="main-grid-head-title">Розничная</span></th>
                <th scope="col"><span class="main-grid-head-title">Служебная Информация</span></th>
                <th scope="col"><span class="main-grid-head-title">Наличие</span></th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr class="js-product-item" wire:key="product-{{$product['id']}}">
                    <td>
                        <div class="form-check">
                            <input wire:model.defer="products.{{$product['id']}}.is_checked" @if($editMode) disabled @endif class="form-check-input position-static" type="checkbox">
                        </div>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary" type="button" id="actions-dropdown-{{$product['id']}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bars"></i></button>
                            <div class="dropdown-menu" aria-labelledby="actions-dropdown-{{$product['id']}}">
                                <a class="dropdown-item" href="{{route("admin.products.edit", $product['id'])}}">Изменить</a>
                                <button type="button" class="dropdown-item btn btn-link" wire:click="toggleActive({{$product['id']}})">
                                    @if($product['is_active'])
                                        Деактивировать
                                    @else
                                        Активировать
                                    @endif
                                </button>
                                <a class="dropdown-item" href="{{route(\App\Constants::ROUTE_ADMIN_PRODUCTS_CREATE, ['copy_id' => $product['id']])}}">Копировать</a>
                                <button type="button" class="dropdown-item btn btn-link" onclick="if (confirm('Вы уверены, что хотите удалить продукт `{{$product['id']}}` `{{$product['name']}}` ?')) {@this.handleDelete({{$product['id']}});}">Удалить</button>
                            </div>
                        </div>
                    </td>
                    <td><span class="main-grid-cell-content">{{$product['id']}}</span></td>
                    <td @if($editMode && $product['is_checked']) style="width: 200px;" @endif>
                        @if($editMode && $product['is_checked'])
                            @include('admin.livewire.includes.form-control-input', ['field' => "products.{$product['id']}.ordering"])
                        @else
                            <span class="main-grid-cell-content">{{$product['ordering']}}</span>
                        @endif
                    </td>
                    <td>
                        @if($editMode && $product['is_checked'])
                            @include('admin.livewire.includes.form-control-input', ['field' => "products.{$product['id']}.name"])
                        @else
                            <span class="main-grid-cell-content"><a href="{{route("admin.products.edit", $product['id'])}}">{!! $product['name'] !!}</a></span>
                        @endif
                    </td>
                    <td>
                        @if($editMode && $product['is_checked'])
                            @include('admin.livewire.includes.form-check', ['field' => "products.{$product['id']}.is_active"])
                        @else
                            <span class="main-grid-cell-content">{{$product['is_active_name']}}</span>
                        @endif
                    </td>
                    <td>
                        @if($editMode && $product['is_checked'])
                            @include('admin.livewire.includes.form-control-input', ['field' => "products.{$product['id']}.unit"])
                        @else
                            <span class="main-grid-cell-content">{{$product['unit']}}</span>
                        @endif
                    </td>
                    <td>
                        @if($editMode && $product['is_checked'])
                            <div class="form-row">
                                <div class="col">
                                    @include('admin.livewire.includes.form-control-input', ['field' => "products.{$product['id']}.price_purchase"])
                                </div>
                                <div class="col">
                                    @include('admin.livewire.includes.form-control-select', ['field' => "products.{$product['id']}.price_purchase_currency_id", 'options' => $currencies])
                                </div>
                            </div>
                        @else
                            <span class="main-grid-cell-content">{{$product['price_purchase_formatted']}}</span>
                        @endif
                    </td>
                    <td>
                        @if($editMode && $product['is_checked'])
                            <div class="form-row">
                                <div class="col">
                                    @include('admin.livewire.includes.form-control-input', ['field' => "products.{$product['id']}.price_retail"])
                                </div>
                                <div class="col">
                                    @include('admin.livewire.includes.form-control-select', ['field' => "products.{$product['id']}.price_retail_currency_id", 'options' => $currencies])
                                </div>
                            </div>
                        @else
                            <span class="main-grid-cell-content">{{$product['price_retail_formatted']}}</span>
                        @endif
                    </td>
                    <td>
                        @if($editMode && $product['is_checked'])
                            @include('admin.livewire.includes.form-control-textarea', ['field' => "products.{$product['id']}.admin_comment"])
                        @else
                            <span class="main-grid-cell-content">{{$product['admin_comment']}}</span>
                        @endif
                    </td>
                    <td>
                        @if($editMode && $product['is_checked'])
                            @include('admin.livewire.includes.form-control-select', ['field' => "products.{$product['id']}.availability_status_id", 'options' => $availabilityStatuses])
                        @else
                            <span class="main-grid-cell-content">{{$product['availability_status_name']}}</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="row">
        <div class="col-sm-1">
            Всего: {{$total}}
        </div>
        <div class="col-sm-9">
            {{ $paginator->links("admin.pagination.livewire-bootstrap") }}
        </div>
        <div class="col-sm-2">
            @include('admin.livewire.includes.form-group-select', ['field' => 'per_page', 'label' => 'На странице', 'options' => $per_page_options, 'wire' => ['change' => 'handleSearch'], 'nullOption' => false])
        </div>
    </div>

    <div class="row pb-5">
        @if(!$editMode)
            <div class="col-sm-3" wire:key="edit-btn">
                <button wire:click.prevent="$set('editMode', true)" type="button" class="btn btn-light"><i class="fa fa-edit"></i> Редактировать</button>
            </div>
            <div class="col-sm-3" wire:key="delete-btn">
                <button onclick="if (confirm('Вы уверены, что хотите удалить продукт выбранные продукты?')) {@this.deleteSelected()}" type="button" class="btn btn-light"><i class="fa fa-times"></i> Удалить</button>
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
