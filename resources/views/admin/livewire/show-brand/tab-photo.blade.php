<?php
/** @var array $mainImage @see {@link \Domain\Common\DTOs\FileDTO} */
?>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Основное фото:</label>
    <div class="col-sm-9">
        <div class="row">
            <div class="card text-center col-3">
                @if(!empty($mainImage))
                    <div class="card-body">
                        <a href="{{$mainImage['url']}}" target="_blank"><img class="img-thumbnail" src="{{$mainImage['url']}}" alt=""></a>
                        <div class="form-group">
                            @include('admin.livewire.includes.form-control-input', ['field' => "mainImage.name"])
                        </div>
                        <button wire:click="deleteMainImage" type="button" class="btn btn-outline-danger">x</button>
                    </div>
                @endif
            </div>
        </div>
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
