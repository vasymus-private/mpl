<?php
/**
 * @var string $field
 * @var string $modifier
 */
?>
<input wire:model{{$modifier ?? ''}}="{{$field}}" type="text" class="form-control @error($field) is-invalid @enderror" id="{{$field}}">
@error($field) <div class="invalid-feedback">{{ $message }}</div> @enderror
