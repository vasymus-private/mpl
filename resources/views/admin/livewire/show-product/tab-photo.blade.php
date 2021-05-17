<?php
/** @var array|null $mainImage @see {@link \Domain\Common\DTOs\FileDTO} */
/** @var array[] $additionalImages @see {@link \Domain\Common\DTOs\FileDTO} */
?>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Основное фото:</label>
    <div class="col-sm-9">
        @if(!empty($mainImage))
        <div class="row">
            <div class="card text-center col-3">
                <div class="card-body">
                    <a href="{{$mainImage['path']}}" target="_blank"><img class="img-thumbnail" src="{{$mainImage['path']}}" alt=""></a>
                    <div class="form-group">
                        @include('admin.livewire.includes.form-control-input', ['field' => "mainImage.name"])
                    </div>
                    <button wire:click="deleteMainImage" type="button" class="btn btn-outline-danger">x</button>
                </div>
            </div>
        </div>
        @endif
        <div class="form-group">
            <label for="tempMainImage">Загрузить основное фото</label>
            <input type="file" wire:model="tempMainImage" class="form-control-file @error("tempMainImage") is-invalid @enderror" id="tempMainImage" />
            <div wire:loading wire:target="tempMainImage">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            @error("tempMainImage") <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Дополнительные фото:</label>
    <div class="col-sm-9">
        <div class="row">
            @foreach($additionalImages as $index => $additionalImage)
                <div wire:key="instructions-{{$index}}-{{$additionalImage['path']}}" class="card text-center col-3">
                    <div class="card-body">
                        <a href="{{$additionalImage['path']}}" target="_blank"><img class="img-thumbnail" src="{{$additionalImage['path']}}" alt=""></a>
                        <div class="form-group">
                            @include('admin.livewire.includes.form-control-input', ['field' => "additionalImages.$index.name"])
                        </div>
                        <button wire:click="deleteAdditionalImage({{$index}})" type="button" class="btn btn-outline-danger">x</button>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="form-group">
            <label for="tempAdditionalImage">Добавить дополнительное фото</label>
            <input type="file" wire:model="tempAdditionalImage" class="form-control-file @error("tempAdditionalImage") is-invalid @enderror" id="tempAdditionalImage" />
            <div wire:loading wire:target="tempAdditionalImage">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            @error("tempAdditionalImage") <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
</div>
