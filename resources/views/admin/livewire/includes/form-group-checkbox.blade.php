<?php
/**
 * @var string $field
 * @var bool $defer Default `true`
 * @var string $label
 */
?>
<div class="form-group row">
    <div class="col-sm-5">
        <label class="form-check-label" for="{{$field}}">{{$label}}:</label>
    </div>
    <div class="col-sm-7">
        @include('admin.livewire.includes.form-check', ['field' => $field, 'defer' => $defer])
    </div>
</div>
