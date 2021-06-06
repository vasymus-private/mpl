<?php
/**
 * @var \App\Http\Livewire\Admin\ShowCategory $this
 * @var \Domain\Products\Models\Category $item
 * @var string[] $tabs @see {@link \App\Http\Livewire\Admin\ShowCategory::$tabs}
 * @var string $activeTab @see {@link \App\Http\Livewire\Admin\ShowCategory::$activeTab}
 * @var \Illuminate\Support\ViewErrorBag $errors
 */
?>
<div class="py-4">
    <div class="detail-toolbar">
        <div class="row d-flex align-items-center">
            <div class="col-sm-7">
                <a href="{{route('admin.categories.index', ['category_id' => $item->parent_id])}}" class="detail-toolbar__btn">
                    <span class="detail-toolbar__btn-l"></span>
                    <span class="detail-toolbar__btn-text">Разделы</span>
                    <span class="detail-toolbar__btn-r"></span>
                </a>
            </div>
            @if($item->id)
                <div class="col-sm-5 d-flex align-items-center">
                    <a href="{{route('admin.categories.create')}}" class="btn btn-info mx-1">Добавить раздел</a>
                    <button type="button" wire:click="deleteItem" class="btn btn-danger mx-1">Удалить раздел</button>
                </div>
            @endif
        </div>
    </div>

    <ul class="nav nav-tabs item-tabs" role="tablist">
        @foreach($tabs as $tab => $label)
            <li wire:key="{{ $tab }}" class="nav-item" role="presentation">
                <a wire:click="selectTab('{{$tab}}')" wire:ignore.self class="nav-link @if($tab === $activeTab) active @endif" data-toggle="tab" id="{{$tab}}-tab" href="#{{$tab}}" role="tab" aria-controls="{{$tab}}" aria-selected="{{$tab === $activeTab ? 'true' : 'false'}}">{{$label}}</a>
            </li>
        @endforeach
    </ul>

    <form wire:submit.prevent="save">
        <div class="tab-content">
            @foreach($tabs as $tab => $label)
                <div wire:key="{{ $tab }}"  wire:ignore.self class="tab-pane p-3 fade @if($tab === $activeTab) show active @endif" id="{{$tab}}" role="tabpanel" aria-labelledby="{{$tab}}-tab">
                    @include("admin.livewire.show-category.tab-$tab")
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary mb-2 btn__save">Сохранить</button>

        @if(!empty($errors->all()))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach($errors->all() as $index =>$error)
                    <div wire:key="{{"{$index}-{$error}"}}" >{{$error}}</div>
                @endforeach
                <button type="button" wire:click="clearValidationErrors" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </form>
</div>
