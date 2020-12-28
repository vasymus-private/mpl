import Swiper from 'swiper'

(function ($) {
    $(document).ready(() => {
        const sliders = [];
        for (let i = 0; i < 10; i++) {
            const selector = `.js-slider-${i + 1}`;
            if (!$(selector).length) continue;

            sliders.push(window[`slider-${i + 1}`] = new Swiper(selector, {
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
                navigation: {
                    nextEl: `.swiper-button-next.js-slider-btn-${i + 1}`,
                    prevEl: `.swiper-button-prev.js-slider-btn-${i + 1}`,
                },
            }))
        }
    })
})(jQuery)
