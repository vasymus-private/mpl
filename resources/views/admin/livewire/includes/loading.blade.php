<?php
/**
 * @var string|null $target
 */
?>
<div wire:loading.flex @if($target ?? null) wire:target="{{$target}}" @endif>
    <div class="d-flex justify-content-center align-items-center bg-light" style="opacity: 0.5; position:absolute; top:0; bottom:0; right:0; left:0; z-index: 20; ">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</div>
