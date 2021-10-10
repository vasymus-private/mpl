<?php
/**
 * @var \App\Http\Livewire\Admin\ShowCategory $this
 * @see {@link \App\Http\Livewire\Admin\ShowCategory::$seo}
 */
?>
@include('admin.livewire.includes.form-group-input', ['field' => 'seo.title', 'label' => 'Заголовок окна браузера'])

@include('admin.livewire.includes.form-group-input', ['field' => 'seo.h1', 'label' => 'Заголовок страницы (h1)'])

@include('admin.livewire.includes.form-group-input', ['field' => 'seo.keywords', 'label' => 'Meta Keywords'])

@include('admin.livewire.includes.form-group-textarea', ['field' => 'seo.description', 'label' => 'Meta Description'])
