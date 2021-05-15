<input wire:model.defer="{{$field}}" type="text" class="form-control @error($field) is-invalid @enderror" id="{{$field}}">
@error($field) <div class="invalid-feedback">{{ $message }}</div> @enderror
