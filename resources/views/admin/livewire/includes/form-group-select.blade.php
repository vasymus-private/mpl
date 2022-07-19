<?php
/**
 * @var string $field
 * @var array[] $options {@see \Domain\Common\DTOs\OptionDTO}
 * @var bool $defer Default `true`
 * @var bool $nullOption Default `true`
 * @var string $placeholder
 * @var string $label
 */
?>
@if($isRow ?? true)
    <div class="form-group row">
        <label for="{{$field}}" class="col-sm-5 col-form-label">{{$label}}:</label>
        <div class="col-sm-7 d-flex align-items-center {{$className ?? ''}}">
            @include('admin.livewire.includes.form-control-select', [
                'field' => $field,
                'options' => $options,
                'defer' => $defer ?? true,
                'wire' => $wire ?? [],
                'nullOption' => $nullOption ?? true,
                'placeholder' => $placeholder ?? '(не установлено)'
            ])
        </div>
    </div>
@else
    <div class="form-group">
        <label for="{{$field}}" class="col-sm-5 col-form-label">{{$label}}:</label>
        <div class="col-sm-7 d-flex align-items-center">
            @include('admin.livewire.includes.form-control-select', [
                'field' => $field,
                'options' => $options,
                'defer' => $defer ?? true,
                'wire' => $wire ?? [],
                'nullOption' => $nullOption ?? true,
                'placeholder' => $placeholder ?? '(не установлено)'
            ])
        </div>
    </div>
@endif
