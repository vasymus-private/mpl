<div class="form-group row">
    <label for="{{$field}}" class="col-sm-3 col-form-label">{{$label}}:</label>
    <div class="col-sm-9">
        <select wire:model.defer="product.{{$field}}" class="form-control" id="{{$field}}">
            <option value="">(не установлено)</option>
            @foreach($options as $option)
                <option value="{{$option['value']}}">{{$option['label']}}</option>
            @endforeach
        </select>
    </div>
</div>
