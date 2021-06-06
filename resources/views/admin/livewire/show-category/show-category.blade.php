<?php
/**
 * @var \App\Http\Livewire\Admin\ShowCategory $this
 *
 */
?>
<div>
    <ul class="nav nav-tabs product-tabs" role="tablist">
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

        @foreach($errors->all() as $error)
            <div wire:key="{{$error}}" class="alert alert-danger alert-dismissible fade show" role="alert">
                {{$error}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endforeach
    </form>
</div>
