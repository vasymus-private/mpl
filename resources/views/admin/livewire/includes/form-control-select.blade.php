<?php
/**
 * @var string $field
 * @var array[] $options {@see \Domain\Common\DTOs\OptionDTO}
 */
?>
<select wire:model.defer="{{$field}}" class="form-control @error($field) is-invalid @enderror" id="{{$field}}">
    <option value="">(не установлено)</option>
    @foreach($options as $option)
        <option value="{{$option['value']}}">{{$option['label']}}</option>
    @endforeach
</select>
@error($field) <div class="invalid-feedback">{{ $message }}</div> @enderror
