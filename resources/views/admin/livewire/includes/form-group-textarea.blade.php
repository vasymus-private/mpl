<div class="form-group row">
    <label for="{{$field}}" class="col-sm-3 col-form-label">{{$label}}:</label>
    <div class="col-sm-9">
        <textarea wire:model.defer="{{$field}}" class="form-control @error($field) is-invalid @enderror" id="{{$field}}" rows="3"></textarea>
        @error($field) <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
