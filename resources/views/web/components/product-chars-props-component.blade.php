<?php
/** @var \Domain\Products\Models\Product\Product $product */
?>

@if($product->characteristicsNotEmpty())
<table cellspacing="0" cellpadding="0" class="product-properties">
    @foreach($product->characteristics() as $groupName => $labelValues)
    <tbody>
        <tr>
            <th colspan="2">
                <div class="product-properties__title">{{$groupName}}</div>
            </th>
        </tr>
        @foreach($labelValues as $label => $value)
            <tr>
                <td>{{$label}}</td>
                <td>
                    <div class="dotted_line">
                        @if(in_array($label, \Domain\Products\Models\Product\Product::CH_RATE))
                            @for($i = 0; $i < \Domain\Products\Models\Product\Product::MAX_CHARACTERISTIC_RATE; $i++)
                                @if($value > $i)
                                    <span><img src="{{asset("images/general/circle-active.gif")}}" alt=""></span>
                                @else
                                    <span><img src="{{asset("images/general/circle.gif")}}" alt=""></span>
                                @endif
                            @endfor
                        @else
                            {{$value}}
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
    @endforeach
</table>
@else
    <p style="text-align: center;">---</p>
@endif
