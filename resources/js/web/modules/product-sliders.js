import Swiper, { Navigation } from "swiper"
;(function ($) {
    $().ready(() => {
        const sliders = []
        for (let i = 0; i < 10; i++) {
            const selector = `.js-slider-${i + 1}`
            if (!$(selector).length) continue

            sliders.push(
                new Swiper(selector, {
                    modules: [Navigation],
                    slidesPerView: 3,
                    freeMode: false,
                    breakpoints: {
                        // when window width is <= 320px
                        320: {
                            slidesPerView: 1,
                        },
                        // when window width is <= 480px
                        480: {
                            slidesPerView: 2,
                        },
                        // when window width is <= 640px
                        768: {
                            slidesPerView: 2,
                        },
                        1000: {
                            slidesPerView: 3,
                        },
                    },
                    uniqueNavElements: false,
                    navigation: {
                        nextEl: document.querySelector(
                            `.swiper-button-next.js-slider-btn-${i + 1}`
                        ),
                        prevEl: document.querySelector(
                            `.swiper-button-prev.js-slider-btn-${i + 1}`
                        ),
                    },
                })
            )
        }
    })
})(jQuery)
