<?php
/**
 * @var string $field
 * @var array[] $options {@see \Domain\Common\DTOs\OptionDTO}
 * @var bool $defer Default `true`
 * @var bool $nullOption Default `true`
 * @var string $placeholder
 */
?>
<select wire:model{{$defer ?? true ? '.defer' : ''}}="{{$field}}" @foreach(($wire ?? []) as $wireName => $wireValue) wire:{{$wireName}}="{{$wireValue}}" @endforeach class="form-control @error($field) is-invalid @enderror" id="{{$field}}">
    @if($nullOption ?? true) <option value="">{{$placeholder ?? '(не установлено)'}}</option> @endif
    @foreach($options as $option)
        <option value="{{$option['value']}}">{{$option['label']}}</option>
    @endforeach
</select>
@error($field) <div class="invalid-feedback">{{ $message }}</div> @enderror
