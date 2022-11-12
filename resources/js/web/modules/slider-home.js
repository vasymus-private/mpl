var slider = (function ($) {
    "use strict"

    function init() {
        $(".slider-home").slick({
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            dots: true,
        })
    }

    return {
        init: init,
    }
})(jQuery)

export default slider
