<?php
/**
 * @var \App\Http\Livewire\Admin\ShowOrder\ShowOrder $this
 * @var \Domain\Orders\Models\Order $item @see {@link \App\Http\Livewire\Admin\ShowOrder\ShowOrder::$item}
 * @var bool $isCreating @see {@link \App\Http\Livewire\Admin\ShowOrder\ShowOrder::$isCreating}
 * @var string $activeTab @see
 * @var \Illuminate\Support\ViewErrorBag $errors
 */
?>
<div class="py-4">
    <h1 class="h2">
        @if($isCreating)
            Добавление заказа
        @else
            Заказ № {{ $item->id }}
        @endif
    </h1>

    <div class="detail-toolbar">
        <div class="row d-flex align-items-center">
            <div class="col-sm-7">
                <a href="{{route(\App\Constants::ROUTE_ADMIN_ORDERS_INDEX)}}" class="detail-toolbar__btn">
                    <span class="detail-toolbar__btn-l"></span>
                    <span class="detail-toolbar__btn-text">Список заказов</span>
                    <span class="detail-toolbar__btn-r"></span>
                </a>
            </div>

            @if(!$isCreating)
                <div class="col-sm-5 d-flex align-items-center">
                    @if($editMode)
                        <a href="{{route(\App\Constants::ROUTE_ADMIN_ORDERS_EDIT, ['admin_order' => $item->id, 'editMode' => 0])}}" class="btn btn-secondary dropdown-toggle btn__dropdown">
                            Подробности заказа
                        </a>
                    @else
                        <a href="{{route(\App\Constants::ROUTE_ADMIN_ORDERS_EDIT, ['admin_order' => $item->id, 'editMode' => 1])}}" class="btn btn-secondary dropdown-toggle btn__dropdown">
                            Изменить заказ
                        </a>
                    @endif

                    <a href="{{route(\App\Constants::ROUTE_ADMIN_ORDERS_CREATE)}}" class="btn btn-secondary dropdown-toggle btn__dropdown">
                        Создать заказ
                    </a>

                    <button wire:click.prevent="handleDeleteOrder" type="button" class="btn btn-secondary dropdown-toggle btn__dropdown">
                        Удалить заказ
                    </button>
                </div>
            @endif
        </div>
    </div>

    <ul class="nav nav-tabs item-tabs" role="tablist">
        @foreach($this->tabs() as $tab => $label)
            <li wire:key="{{ $tab }}" class="nav-item" role="presentation">
                <a wire:click="selectTab('{{$tab}}')" wire:ignore.self class="nav-link @if($tab === $activeTab) active @endif" data-toggle="tab" id="{{$tab}}-tab" href="#{{$tab}}" role="tab" aria-controls="{{$tab}}" aria-selected="{{$tab === $activeTab ? 'true' : 'false'}}">{{$label}}</a>
            </li>
        @endforeach
    </ul>

    <form wire:submit.prevent="handleSave" class="position-relative">
        <div wire:loading.flex wire:target="handleSave">
            <div class="d-flex justify-content-center align-items-center bg-light" style="opacity: 0.5; position:absolute; top:0; bottom:0; right:0; left:0; z-index: 20; ">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
        <div class="tab-content">
            @foreach($this->tabs() as $tab => $label)
                <div
                    wire:key="{{ $tab }}"
                    wire:ignore.self
                    class="tab-pane p-3 fade @if($tab === $activeTab) show active @endif"
                    id="{{$tab}}"
                    role="tabpanel"
                    aria-labelledby="{{$tab}}-tab"
                >
                    @include("admin.livewire.show-order.tab-$tab")
                </div>
            @endforeach
        </div>

        <div class="edit-item-footer">
            <button type="submit" class="btn btn-primary mb-2 btn__save mr-2">Сохранить</button>

            <a href="{{route(\App\Constants::ROUTE_ADMIN_ORDERS_INDEX)}}" type="button" class="btn btn-info mb-2 btn__default">Отменить</a>
        </div>
    </form>

    @foreach($errors->all() as $error)
        <div wire:key="{{$error}}" class="alert alert-danger alert-dismissible fade show" role="alert">
            {{$error}}
            <button type="button" wire:click="clearValidationErrors" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endforeach

</div>
