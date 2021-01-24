<div id="extra" class="sidebar-filter">
    <div class="sidebar-filter__content">
        <div class="sidebar-filter__title">
            <span class="sidebar-filter__check">
                <i class="fa fa-check" aria-hidden="true"></i>
            </span>
            Производители:
        </div>
        <form action="#" id="filter-form" class="filter-form">

            @foreach($brands as $brand)
                <?php /** @var \Domain\Products\Models\Brand $brand*/ ?>
                <div class="filter-form__item">
                    <input id="acm" class="filter-form__checkbox" name="brands[]" value="{{$brand->id}}" type="checkbox"/>
                    <label for="acm" class="filter-form__label">
                        <div class="filter-form__article">
                            <a href="#" class="filter-form__link">{{$brand->name}}</a>
                            <span class="filter-product-count">{{$brand->products_count}}</span>
                        </div>
                    </label>
                </div>
            @endforeach

            <div class="filter-form__item">
                <input type="submit" class="filter-form__submit" value="Выбрать">
                <input type="button" class="filter-form__reset" value="Сбросить">
            </div>
        </form>
    </div>
</div>
