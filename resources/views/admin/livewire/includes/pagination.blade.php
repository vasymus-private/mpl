<?php
/**
 * @var int $total
 * @var \Illuminate\Pagination\LengthAwarePaginator $paginator
 * @var array[] $options @see {@link \Domain\Common\DTOs\OptionDTO[]}
 * @var string $wire
 * @var int[] $sizes Default to [1, 9, 2]
 * @var bool $formGroup Default to `true`
 */
?>
<div class="row">
    <div class="col-sm-{{isset($sizes) ? $sizes[0] : 1}}">
        Всего: {{$total}}
    </div>
    <div class="col-sm-{{isset($sizes) ? $sizes[1] : 9}}">
        {{ $paginator->links("admin.pagination.livewire-bootstrap") }}
    </div>
    <div class="col-sm-{{isset($sizes) ? $sizes[2] : 2}}">
        @if($formGroup ?? true)
            @include('
                admin.livewire.includes.form-group-select',
                array_merge([
                    'field' => 'per_page',
                    'label' => 'На странице',
                    'nullOption' => false,
                ], compact('options', 'wire'))
            )
        @else
            @include(
                'admin.livewire.includes.form-control-select',
                array_merge([
                    'field' => 'per_page',
                    'nullOption' => false,
                ], compact('options', 'wire'))
            )
        @endif
    </div>
</div>
