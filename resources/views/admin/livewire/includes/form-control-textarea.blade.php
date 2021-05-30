<textarea wire:model.defer="{{$field}}" class="form-control {{$class ?? ''}} @error($field) is-invalid @enderror" id="{{$field}}" rows="3"></textarea>
@error($field) <div class="invalid-feedback">{{ $message }}</div> @enderror
