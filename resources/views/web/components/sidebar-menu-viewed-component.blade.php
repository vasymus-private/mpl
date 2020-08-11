<?php /** @var \App\Models\Product\Product[]|\Illuminate\Database\Eloquent\Collection $viewed */ ?>
@if($viewed->isNotEmpty())
<div class="watched-block">
    <h4 class="watched-block__title">Вы смотрели</h4>
    <div class="watched-block__body">
        @foreach($viewed as $viewedItem)
        <div class="row-line">
            <div class="column">
                <a href="{{$viewedItem->web_route}}">
                    <img
                        width="40"
                        height="40"
                        align="left"
                        src="{{$viewedItem->getFirstMediaUrl(\App\Models\Product\Product::MC_MAIN_IMAGE)}}"
                        style="margin-right: 10px;"
                        alt="{{$viewedItem->name}}"
                    />
                </a>
            </div>
            <div class="column">
                <div class="product-special">
                    <a title="{{$viewedItem->name}}" href="{{$viewedItem->web_route}}">{{$viewedItem->name}}</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
