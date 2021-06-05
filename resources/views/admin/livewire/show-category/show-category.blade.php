<?php
/**
 * @var \App\Http\Livewire\Admin\ShowCategory $this
 *
 */
?>
<div>
    <ul class="nav nav-tabs product-tabs" role="tablist">
        @foreach($tabs as $tab => $label)
            <li wire:key="{{ $tab }}" class="nav-item @if(!$is_with_variations && $tab === 'variations') d-none @endif" role="presentation">
                <a wire:click="selectTab('{{$tab}}')" wire:ignore.self class="nav-link @if($tab === $activeTab) active @endif" data-toggle="tab" id="{{$tab}}-tab" href="#{{$tab}}" role="tab" aria-controls="{{$tab}}" aria-selected="{{$tab === $activeTab ? 'true' : 'false'}}">{{$label}}</a>
            </li>
        @endforeach
    </ul>
</div>
