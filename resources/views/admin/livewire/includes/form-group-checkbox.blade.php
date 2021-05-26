<div class="form-group row">
    <div class="col-sm-3">
        <label class="form-check-label" for="{{$field}}">{{$label}}:</label>
    </div>
    <div class="col-sm-9">
        @include('admin.livewire.includes.form-check', ['field' => $field])
    </div>
</div>
