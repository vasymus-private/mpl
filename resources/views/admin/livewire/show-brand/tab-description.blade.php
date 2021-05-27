<div class="form-group">
    <label for="brand.preview">Описание для анонса</label>
    <div class="nav nav-tabs" role="tablist">
        <a class="nav-link" id="preview-html-tab" data-toggle="tab" href="#preview-html" role="tab" aria-controls="preview-html" aria-selected="false">HTML</a>
        <a class="nav-link active" id="preview-editor-tab" data-toggle="tab" href="#preview-editor" role="tab" aria-controls="preview-editor" aria-selected="true">Визуальный редактор</a>
    </div>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade" id="preview-html" role="tabpanel" aria-labelledby="preview-html-tab" style="height: 600px">
            @include('admin.livewire.includes.form-control-textarea', ['field' => 'brand.preview', 'class' => 'h-100'])
        </div>
        <div class="tab-pane fade show active" id="preview-editor" role="tabpanel" aria-labelledby="preview-editor-tab">
            <textarea id="brand-preview-tinymce"></textarea>
            @error('brand.preview') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
</div>

<div class="form-group">
    <label for="brand.description">Детальное описание</label>
    <div class="nav nav-tabs" role="tablist">
        <a class="nav-link" id="description-html-tab" data-toggle="tab" href="#description-html" role="tab" aria-controls="description-html" aria-selected="false">HTML</a>
        <a class="nav-link active" id="description-editor-tab" data-toggle="tab" href="#description-editor" role="tab" aria-controls="description-editor" aria-selected="true">Визуальный редактор</a>
    </div>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade" id="description-html" role="tabpanel" aria-labelledby="description-html-tab" style="height: 600px">
            @include('admin.livewire.includes.form-control-textarea', ['field' => 'brand.description', 'class' => 'h-100'])
        </div>
        <div class="tab-pane fade show active" id="description-editor" role="tabpanel" aria-labelledby="description-editor-tab">
            <textarea id="brand-description-tinymce"></textarea>
            @error('brand.description') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
