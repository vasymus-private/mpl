<div class="form-group row">
    <label for="brand.name" class="col-sm-3 col-form-label font-weight-bold">Название:</label>
    <div class="col-sm-9">
        <div class="input-group mb-3">
            <input wire:model.debounce.1000ms="brand.name" type="text" class="form-control @error('brand.name') is-invalid @enderror" id="brand.name">
            <div class="input-group-append">
                <button wire:click="toggleGenerateSlugMode" class="btn btn-outline-secondary" type="button"><i class="fa {{$generateSlugSyncMode ? 'fa-chain' : 'fa-chain-broken'}}" aria-hidden="true"></i></button>
            </div>
        </div>
        @error('brand.name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="form-group row">
    <label for="brand.slug" class="col-sm-3 col-form-label">Символьный код:</label>
    <div class="col-sm-9">
        <div class="input-group mb-3">
            <input wire:model.defer="brand.slug" type="text" class="form-control @error('brand.slug') is-invalid @enderror" id="brand.slug">
            <div class="input-group-append">
                <button wire:click="toggleGenerateSlugMode" class="btn btn-outline-secondary" type="button"><i class="fa {{$generateSlugSyncMode ? 'fa-chain' : 'fa-chain-broken'}}" aria-hidden="true"></i></button>
            </div>
        </div>
        @error('brand.slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

@include('admin.livewire.includes.form-group-input', ['field' => 'brand.ordering', 'label' => 'Сортировка'])
