<?php
/**
 * @var string $field
 * @var bool $defer Default `true`
 */
?>
<div class="form-check @error($field) is-invalid @enderror">
    <input wire:model{{$defer ?? true ? '.defer' : ''}}="{{$field}}" class="form-check-input" type="checkbox" id="{{$field}}">
</div>
@error($field) <div class="invalid-feedback mt-4">{{ $message }}</div> @enderror
