<?php
/**
 * @var bool|null $isRow Default is true
 * @var string $field
 * @var string $label
 */
?>
@if($isRow ?? true)
    <div class="form-group row">
        <label for="{{$field}}" class="col-sm-5 col-form-label">{{$label}}:</label>
        <div class="col-sm-7">
            @include('admin.livewire.includes.form-control-textarea', ['field' => $field])
        </div>
    </div>
@else
    <div class="form-group">
        <label for="{{$field}}">{{$label}}:</label>
        @include('admin.livewire.includes.form-control-textarea', ['field' => $field])
    </div>
@endif
