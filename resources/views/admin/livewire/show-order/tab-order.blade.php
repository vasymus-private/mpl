<?php
/**
 * @var \App\Http\Livewire\Admin\ShowOrder\ShowOrder $this
 * @var bool $isCreating @see {@link \App\Http\Livewire\Admin\ShowOrder\ShowOrder::$isCreating}
 * @var \Domain\Orders\Models\Order $item @see {@link \App\Http\Livewire\Admin\ShowOrder\ShowOrder::$item}
 * @var array[] $orderStatuses @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Orders\Models\OrderStatus}
 * @var string $email @see {@link \App\Http\Livewire\Admin\ShowOrder\ShowOrder::$email}
 * @var string $name @see {@link \App\Http\Livewire\Admin\ShowOrder\ShowOrder::$name}
 * @var string $phone @see {@link \App\Http\Livewire\Admin\ShowOrder\ShowOrder::$phone}
 * @var array[] $paymentMethods @see {@link \App\Http\Livewire\Admin\ShowOrder\ShowOrder::$paymentMethods}
 * @var array[] $managers @see {@link \App\Http\Livewire\Admin\ShowOrder\ShowOrder::$managers}
 * @var array[] $orderImportance @see {@link \App\Http\Livewire\Admin\ShowOrder\ShowOrder::$orderImportance}
 * @var array[] $billStatuses @see {@link \App\Http\Livewire\Admin\ShowOrder\ShowOrder::$billStatuses}
 */
?>
<div class="item-edit order-edit">
    <div class="h5 text-center bg-info py-2">
        Заказ
    </div>

    @if(!$isCreating)
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Номер заказа:</label>
            <div class="col-sm-7 d-flex align-items-center">
                {{$item->id}}
            </div>
        </div>
    @endif

    @if(!$isCreating)
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Создан:</label>
            <div class="col-sm-7 d-flex align-items-center">
                {{$item->created_at}}
            </div>
        </div>
    @endif

    @if(!$isCreating)
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Последнее изменение:</label>
            <div class="col-sm-7 d-flex align-items-center">
                {{$item->updated_at}}
            </div>
        </div>
    @endif

    @include('admin.livewire.includes.form-group-select', [
        'field' => 'item.order_status_id',
        'className' => 'width-45',
        'label' => 'Статус заказа',
        'options' => $orderStatuses,
    ])

    @if(!$isCreating)
        @if($item->cancelled)
            <div wire:key="order-cancelled" class="form-group row">
                <label class="col-sm-5 col-form-label"><span class="bg-danger d-inline-block p-1 rounded">Заказ отменён: Да</span></label>
                <div class="col-sm-7 d-flex align-items-center">
                    <button wire:click.prevent="handleNotCancelled" type="button" class="btn btn-primary">Снять отмену заказа</button>
                </div>
            </div>
            <div wire:key="order-cancelled-reason" class="form-group row">
                <label class="col-sm-5 col-form-label">Причина отмены:</label>
                <div class="col-sm-7 d-flex align-items-center">
                    {{$item->cancelled_description}}
                </div>
            </div>
        @else
            <div wire:key="order-not-cancelled" class="form-group row">
                <div class="col-sm-7 offset-sm-5 d-flex align-items-center">
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#cancel-order">Отменить заказ</button>
                </div>
            </div>
        @endif
    @endif

    <div class="h5 text-center bg-info py-2">
        Покупатель
    </div>

    @if($isCreating || $this->isEditMode())
        @include('admin.livewire.includes.form-group-input', ['field' => 'email', 'label' => 'E-mail (логин)'])
    @else
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">E-mail (логин):</label>
            <div class="col-sm-7 d-flex align-items-center">
                {{$email}}
            </div>
        </div>
    @endif

    @if($isCreating || $this->isEditMode())
        @include('admin.livewire.includes.form-group-input', ['field' => 'name', 'label' => 'Имя'])
    @else
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Имя:</label>
            <div class="col-sm-7 d-flex align-items-center">
                {{$name}}
            </div>
        </div>
    @endif

    @if($isCreating || $this->isEditMode())
        @include('admin.livewire.includes.form-group-input', ['field' => 'phone', 'label' => 'Телефон'])
    @else
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Телефон:</label>
            <div class="col-sm-7 d-flex align-items-center">
                {{$phone}}
            </div>
        </div>
    @endif

    @if($isCreating || $this->isEditMode())
        @include('admin.livewire.includes.form-group-select', [
            'field' => 'item.payment_method_id',
            'className' => 'width-45',
            'label' => 'Способ оплаты',
            'options' => $paymentMethods,
        ])
    @else
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Способ оплаты:</label>
            <div class="col-sm-7 d-flex align-items-center">
                {{$item->payment->name ?? ''}}
            </div>
        </div>
    @endif

    @if($isCreating || $this->isEditMode())
        @include('admin.livewire.includes.form-group-textarea', [
            'field' => 'item.comment_user',
            'label' => 'Комментарий пользователя',

        ])
    @else
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Комментарий пользователя:</label>
            <div class="col-sm-7 d-flex align-items-center">
                {{$item->comment_user}}
            </div>
        </div>
    @endif

    @if(!$isCreating || !$this->isEditMode() && ($item->initial_attachments->isNotEmpty() || $item->payment_method_attachments->isNotEmpty()))
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Прикрепленные файлы к заказу:</label>
            <div class="col-sm-7">
                @foreach($item->initial_attachments as $media)
                    <p class="mb-0"><a target="_blank" download href="{{route(\App\Constants::ROUTE_ADMIN_MEDIA, ['id' => $media->id, 'name' => $media->name])}}">{{$media->name}}</a></p>
                @endforeach
                @foreach($item->payment_method_attachments as $media)
                    <p class="mb-0"><a target="_blank" download href="{{route(\App\Constants::ROUTE_ADMIN_MEDIA, ['id' => $media->id, 'name' => $media->name])}}">{{$media->name}}</a></p>
                @endforeach
            </div>
        </div>
    @endif

    <div class="h5 text-center bg-info py-2">
        Служебные поля
    </div>

    @if($isCreating || $this->isEditMode())
        @include('admin.livewire.includes.form-group-select', [
            'field' => 'item.admin_id',
            'className' => 'width-45',
            'label' => 'Менеджер',
            'options' => $managers,
        ])
    @else
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Менеджер:</label>
            <div class="col-sm-7 d-flex align-items-center">
                {{$item->admin->name ?? ''}}
            </div>
        </div>
    @endif

    @if($isCreating || $this->isEditMode())
        @include('admin.livewire.includes.form-group-select', [
            'field' => 'item.importance_id',
            'className' => 'width-45',
            'label' => 'Важность',
            'options' => $orderImportance,
        ])
    @else
        <div class="form-group row" style="background-color: {{$item->importance->color ?? 'transparent'}}">
            <label class="col-sm-5 col-form-label">Важность:</label>
            <div class="col-sm-7 d-flex align-items-center">
                {{$item->importance->name ?? ''}}
            </div>
        </div>
    @endif

    @if($isCreating || $this->isEditMode())
        @include('admin.livewire.includes.form-group-textarea', [
            'field' => 'item.customer_bill_description',
            'label' => 'Счёт покупателю',

        ])
    @else
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Счёт покупателю:</label>
            <div class="col-sm-7 d-flex align-items-center">
                {{$item->customer_bill_description}}
            </div>
        </div>
    @endif

    @if($isCreating || $this->isEditMode())
        @include('admin.livewire.includes.form-group-select', [
            'field' => 'item.customer_bill_status_id',
            'className' => 'width-45',
            'label' => 'Статус счёта покупателю',
            'options' => $billStatuses,
        ])
    @else
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Статус счёта покупателю:</label>
            <div class="col-sm-7 d-flex align-items-center">
                {{$item->customerBillStatus->name ?? ''}}
            </div>
        </div>
    @endif

    @if(!$isCreating)
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Приложенные файлы:</label>
            <div class="col-sm-7">
                @if($this->isEditMode())
                <div class="add-file">
                    <div class="row">
                        @foreach($attachments as $index => $attachment)
                            <div wire:key="instructions-{{$index}}-{{$attachment['url']}}" class="card text-center">
                                <div class="adm-fileinput-item-preview">
                                    <h5 class="card-title"><a href="{{$attachment['url']}}" target="_blank">{{$attachment['file_name']}}</a></h5>
                                </div>
                                <div class="form-group">
                                    @include('admin.livewire.includes.form-control-input', ['field' => "attachments.$index.name"])
                                </div>
                                <button wire:click="deleteAttachment({{$index}})" type="button" class="adm-fileinput-item-preview__remove">&nbsp;</button>
                            </div>
                        @endforeach
                    </div>
                    @if($this->isEditMode())
                        <div class="form-group">
                            <div>
                                <span class="add-file__text">Перетащите файлы в эту область (Drag&Drop)</span>
                                <input type="file" wire:model="tempAttachment" class="form-control-file @error("tempAttachment") is-invalid @enderror" id="tempAttachment" />
                                <div wire:loading wire:target="tempAttachment">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            @error("tempAttachment") <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    @endif
                </div>
                @else
                    @foreach($attachments as $attachment)
                        <p><a target="_blank" download href="{{route(\App\Constants::ROUTE_ADMIN_MEDIA, ['id' => $attachment['id'], 'name' => $attachment['name']])}}">{{$attachment['name']}}</a></p>
                    @endforeach
                @endif
            </div>
        </div>
    @endif

    @if($isCreating || $this->isEditMode())
        @include('admin.livewire.includes.form-group-textarea', [
            'field' => 'item.provider_bill_description',
            'label' => 'Счёт от поставщика',

        ])
    @else
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Счёт от поставщика:</label>
            <div class="col-sm-7 d-flex align-items-center">
                {{$item->provider_bill_description}}
            </div>
        </div>
    @endif

    @if($isCreating || $this->isEditMode())
        @include('admin.livewire.includes.form-group-select', [
            'field' => 'item.provider_bill_status_id',
            'className' => 'width-45',
            'label' => 'Статус от поставщика',
            'options' => $billStatuses,
        ])
    @else
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Статус от поставщика:</label>
            <div class="col-sm-7 d-flex align-items-center">
                {{$item->providerBillStatus->name ?? ''}}
            </div>
        </div>
    @endif

    @if($isCreating || $this->isEditMode())
        @include('admin.livewire.includes.form-group-textarea', [
            'field' => 'item.comment_admin',
            'label' => 'Комментарий менеджера',

        ])
    @else
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Комментарий менеджера:</label>
            <div class="col-sm-7 d-flex align-items-center">
                {{$item->comment_admin}}
            </div>
        </div>
    @endif

    <div class="h5 text-center bg-info py-2">
        Заказ
    </div>

    @if($isCreating || $this->isEditMode())
        <div class="search form-group row justify-content-end">
            <div class="col-xs-12 col-sm-2">
                <div class="dropdown">
                    <a href="#" class="btn btn-add btn-secondary">Добавить товар</a>
                </div>
            </div>
        </div>
    @endif

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                @if($isCreating || $this->isEditMode())
                    <th scope="col"><span class="main-grid-head-title">&nbsp;</span></th>
                @endif
                <th scope="col">Изображение</th>
                <th scope="col">Название</th>
                <th scope="col">Количество</th>
                <th scope="col">Свойства</th>
                <th scope="col">Цена</th>
                <th scope="col">Сумма</th>
            </tr>
        </thead>
        <tbody>
        <?php /** @var \Domain\Products\DTOs\Admin\OrderProductItemDTO|array $product */ ?>
        @foreach($productItems as $product)
            <tr wire:key="product-{{$product['uuid']}}">
                @if($isCreating || $this->isEditMode())
                    <td>
                        <div class="dropdown">
                            <button class="btn btn__grid-row-action-button" type="button" id="actions-dropdown-{{$product['uuid']}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                            <div class="dropdown-menu bx-core-popup-menu" aria-labelledby="actions-dropdown-{{$product['uuid']}}">
                                <div class="bx-core-popup-menu__arrow"></div>
                                <button type="button" class="bx-core-popup-menu-item" onclick="@this.selectCurrentProductItem({{$product['id']}}).then(res => {if (res) $('#edit-product-item').modal('show') })">
                                    <span class="bx-core-popup-menu-item-icon adm-menu-edit"></span>
                                    <span class="bx-core-popup-menu-item-text">Изменить</span>
                                </button>
                                <span class="bx-core-popup-menu-separator"></span>
                                <button type="button" class="bx-core-popup-menu-item" wire:click="removeProductItem({{$product['id']}})">
                                    <span class="bx-core-popup-menu-item-icon adm-menu-delete"></span>
                                    <span class="bx-core-popup-menu-item-text">Удалить</span>
                                </button>
                            </div>
                        </div>
                    </td>
                @endif
                <td><div class="text-center"><a target="_blank" href="{{route("admin.products.edit", $product['id'])}}"><img class="img-fluid" src="{{$product['image']}}" alt="" /></a></div></td>
                <td><span class="main-grid-cell-content"><a target="_blank" href="{{route("admin.products.edit", $product['id'])}}">{{$product['name']}}</a></span></td>
                <td><span class="main-grid-cell-content">{{$product['order_product_count']}}</span></td>
                <td>
                    <p>Закупочная: {{$product['price_purchase_rub_formatted']}}</p>
                    <p>Сумма закупки: {{$product['price_purchase_rub_sum_formatted']}}</p>
                    <p>Заработок: {{$product['price_retail_purchase_sum_diff_rub_formatted']}}</p>
                </td>
                <td><span class="main-grid-cell-content">{{$product['price_retail_rub_formatted']}}</span></td>
                <td><span class="main-grid-cell-content">{{$product['price_retail_rub_sum_formatted']}}</span></td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>

<!-- Modals -->
<div wire:ignore.self class="modal fade" id="cancel-order" tabindex="-1" aria-labelledby="cancel-order-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div wire:loading.flex wire:target="handleCancelOrder">
                <div class="d-flex justify-content-center align-items-center bg-light" style="opacity: 0.5; position:absolute; top:0; bottom:0; right:0; left:0; z-index: 20; ">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-header">
                <h5 class="modal-title" id="cancel-order-title">Отмена заказа</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('admin.livewire.includes.form-group-textarea', ['field' => 'cancelMessage', 'label' => 'Причина отмены', 'isRow' => false])
            </div>
            <div class="modal-footer">
                <button onclick="@this.handleCancelOrder().then((res) => { if(res) $('#cancel-order').modal('hide') })" type="button" class="btn btn-primary">Отправить</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
            </div>
        </div>
    </div>
</div>


<div wire:ignore.self class="modal fade" id="edit-product-item" tabindex="-1" aria-labelledby="edit-product-item-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-product-item-title">Редактирование товара</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('admin.livewire.includes.form-group-input', ['field' => 'currentProductItem.name', 'label' => 'Наименование'])
                @include('admin.livewire.includes.form-group-input', ['field' => 'currentProductItem.unit', 'label' => 'Упаковка / Единица'])
                @include('admin.livewire.includes.form-group-input', ['field' => 'currentProductItem.price_purchase_rub_formatted', 'label' => 'Розничная цена (руб)'])
                @include('admin.livewire.includes.form-group-input', ['field' => 'currentProductItem.order_product_count', 'label' => 'Количество'])
            </div>
            <div class="modal-footer">
                <button onclick="@this.handleCancelOrder().then((res) => { if(res) $('#edit-product-item').modal('hide') })" type="button" class="btn btn-primary">Сохранить</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
            </div>
        </div>
    </div>
</div>
