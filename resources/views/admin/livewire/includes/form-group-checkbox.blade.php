<div class="form-group row">
    <div class="col-sm-3">
        <label class="form-check-label" for="{{$field}}">
            {{$label}}:
        </label>
    </div>
    <div class="col-sm-9">
        <div class="form-check @error("product.$field") is-invalid @enderror">
            <input wire:model="product.{{$field}}" class="form-check-input" type="checkbox" id="{{$field}}">
        </div>
        @error("product.$field") <div class="invalid-feedback mt-4">{{ $message }}</div> @enderror
    </div>
</div>
