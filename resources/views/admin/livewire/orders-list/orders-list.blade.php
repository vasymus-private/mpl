<?php
/**
 * @var \App\Http\Livewire\Admin\OrdersList $this
 */
?>
<div>
    <table class="table">
        <thead class="thead-light">
        <tr>
            <th scope="col">
                <div class="form-check">
                    <input wire:model="selectAll" class="form-check-input position-static" type="checkbox">
                </div>
            </th>
            <th scope="col"><span class="main-grid-head-title">&nbsp;</span></th>
            <th scope="col"><span class="main-grid-head-title">Дата создания</span></th>
            <th scope="col"><span class="main-grid-head-title">ID</span></th>
            <th scope="col"><span class="main-grid-head-title">Статус</span></th>
            <th scope="col"><span class="main-grid-head-title">Комментарии</span></th>
            <th scope="col"><span class="main-grid-head-title">Комментарий покупателя</span></th>
            <th scope="col"><span class="main-grid-head-title">Менеджер</span></th>
            <th scope="col"><span class="main-grid-head-title">Сумма</span></th>
            <th scope="col"><span class="main-grid-head-title">Имя</span></th>
            <th scope="col"><span class="main-grid-head-title">Телефон</span></th>
            <th scope="col"><span class="main-grid-head-title">Email</span></th>
            <th scope="col"><span class="main-grid-head-title">Позиции</span></th>
            <th scope="col"><span class="main-grid-head-title">Платежная система</span></th>
        </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>

                </tr>
            @endforeach
        </tbody>
    </table>

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
        <div class="col-sm-3" wire:key="delete-btn">
            <button onclick="if (confirm('Вы уверены, что хотите удалить продукт выбранные продукты?')) {@this.deleteSelected()}" type="button" class="btn btn-light"><i class="fa fa-times"></i> Удалить</button>
        </div>
    </div>
</div>
