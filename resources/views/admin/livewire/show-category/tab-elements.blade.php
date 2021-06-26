<?php
/**
 * @var \App\Http\Livewire\Admin\ShowCategory $this
 * @var bool $generateSlugSyncMode @see {@link \App\Http\Livewire\Admin\ShowCategory::$generateSlugSyncMode}
 * @var array[] $categoriesSelectOptions @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Products\Models\Category} {@link \App\Http\Livewire\Admin\ShowCategory::$categoriesSelectOptions}
 * @see {@link \App\Http\Livewire\Admin\ShowCategory::$item}
 */
?>
<div class="item-edit">
    @include('admin.livewire.includes.form-group-checkbox', ['field' => 'item.is_active', 'label' => 'Активность'])

    @include('admin.livewire.includes.form-group-select', ['field' => 'item.parent_id', 'className' => 'width-45', 'label' => 'Родительский раздел', 'options' => $categoriesSelectOptions])

    <div class="form-group row">
        <label for="item.name" class="col-sm-5 col-form-label font-weight-bold">Название:</label>
        <div class="col-sm-7">
            <div class="input-group">
                <input wire:model.debounce.1000ms="item.name" type="text" class="form-control @error('item.name') is-invalid @enderror" id="item.name">
                <div class="input-group-append">
                    <button wire:click="toggleGenerateSlugMode" class="btn btn-outline-secondary" type="button"><i class="fa {{$generateSlugSyncMode ? 'fa-chain' : 'fa-chain-broken'}}" aria-hidden="true"></i></button>
                </div>
            </div>
            @error('item.name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="item.slug" class="col-sm-5 col-form-label">Символьный код:</label>
        <div class="col-sm-7">
            <div class="input-group">
                <input wire:model.defer="item.slug" type="text" class="form-control @error('item.slug') is-invalid @enderror" id="item.slug">
                <div class="input-group-append">
                    <button wire:click="toggleGenerateSlugMode" class="btn btn-outline-secondary" type="button"><i class="fa {{$generateSlugSyncMode ? 'fa-chain' : 'fa-chain-broken'}}" aria-hidden="true"></i></button>
                </div>
            </div>
            @error('item.slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    @include('admin.livewire.includes.form-group-input', ['field' => 'item.ordering', 'className' => 'width-27', 'label' => 'Сортировка'])


    <div class="form-group">
        <label for="item.description">Описание</label>
        <div class="nav nav-tabs" role="tablist">
            <a class="nav-link" id="description-html-tab" data-toggle="tab" href="#description-html" role="tab" aria-controls="description-html" aria-selected="false">HTML</a>
            <a class="nav-link active" id="description-editor-tab" data-toggle="tab" href="#description-editor" role="tab" aria-controls="description-editor" aria-selected="true">Визуальный редактор</a>
        </div>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade" id="description-html" role="tabpanel" aria-labelledby="description-html-tab" style="height: 600px">
                @include('admin.livewire.includes.form-control-textarea', ['field' => 'item.description', 'class' => 'h-100'])
            </div>
            <div class="tab-pane fade show active" id="description-editor" role="tabpanel" aria-labelledby="description-editor-tab">
                <textarea id="item-description-tinymce"></textarea>
                @error('item.description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:load', () => {
        jQuery(() => {
            if (typeof livewireTinymce === 'function') livewireTinymce()
        })
    })
    document.addEventListener('livewire:update', () => {
        if (typeof livewireTinymce === 'function') livewireTinymce()
    })
</script>
