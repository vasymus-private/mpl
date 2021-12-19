<?php
/**
 * @var bool|null $isRow Default is true
 * @var string $field
 * @var string|null $labelColClass Default is 'col-sm-5'
 * @var string|null $inputColClass Default is 'col-sm-7'
 * @var string $modifier
 */
?>
@if($isRow ?? true)
    <div class="form-group row">
        <label for="{{$field}}" class="{{$labelColClass ?? 'col-sm-5'}} col-form-label {{$labelClass ?? ''}}">{{$label}}:</label>
        <div class="{{$inputColClass ?? 'col-sm-7'}} {{$className ?? ''}}">
            @include('admin.livewire.includes.form-control-input', ['field' => $field])
        </div>
    </div>
@else
    <div class="form-group">
        <label for="{{$field}}">{{$label}}:</label>
        @include('admin.livewire.includes.form-control-input', ['field' => $field, 'modifier' => $modifier ?? ''])
    </div>
@endif
