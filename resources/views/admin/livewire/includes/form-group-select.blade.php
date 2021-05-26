<?php
/**
 * @var string $field
 * @var array[] $options {@see \Domain\Common\DTOs\OptionDTO}
 */
?>
@if($isRow ?? true)
    <div class="form-group row">
        <label for="{{$field}}" class="col-sm-3 col-form-label">{{$label}}:</label>
        <div class="col-sm-9">
            @include('admin.livewire.includes.form-control-select', ['field' => $field, 'options' => $options, 'wire' => $wire ?? []])
        </div>
    </div>
@else
    <div class="form-group">
        <label for="{{$field}}">{{$label}}:</label>
        @include('admin.livewire.includes.form-control-select', ['field' => $field, 'options' => $options, 'wire' => $wire ?? []])
    </div>
@endif
