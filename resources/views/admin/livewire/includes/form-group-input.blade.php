<div class="form-group row">
    <label for="{{$field}}" class="col-sm-3 col-form-label">{{$label}}:</label>
    <div class="col-sm-9">
        <input wire:model.defer="product.{{$field}}" type="text" class="form-control @error("product.$field") is-invalid @enderror" id="{{$field}}">
        @error("product.$field") <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
