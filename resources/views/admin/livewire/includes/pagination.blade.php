<?php
/**
 * @var int $total
 * @var \Illuminate\Pagination\LengthAwarePaginator $paginator
 * @var array[] $options @see {@link \Domain\Common\DTOs\OptionDTO[]}
 * @var string $wire
 */
?>
<div class="row">
    <div class="col-sm-1">
        Всего: {{$total}}
    </div>
    <div class="col-sm-9">
        {{ $paginator->links("admin.pagination.livewire-bootstrap") }}
    </div>
    <div class="col-sm-2">
        @include('
            admin.livewire.includes.form-group-select',
            array_merge([
                'field' => 'per_page',
                'label' => 'На странице',
                'nullOption' => false,
            ], compact('options', 'wire'))
        )
    </div>
</div>
