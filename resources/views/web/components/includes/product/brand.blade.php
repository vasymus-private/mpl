<?php /** @var \App\Models\Brand|null $brand */ ?>
@if($brand)
    <div class="brand-logo-box">
        <h4 class="brand-logo-box__title"><a href="{{route("brands.show", $brand->slug)}}">Производитель</a></h4>
        <a href="{{route("brands.show", $brand->slug)}}" class="brand-logo-box__link"><img src="{{$brand->getFirstMediaUrl(\App\Models\Brand::MC_MAIN_IMAGE)}}" alt="" title=""></a>
    </div>
@endif
