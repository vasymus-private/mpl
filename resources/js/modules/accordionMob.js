var accordionMob = (function ($) {
    'use strict';

    function init() {
        var allAccordions = $('.accordion .data');
        var allAccordionItems = $('.accordion .accordion-item');

        $('.accordion .accordion-item').click(function (e) {
            if ($(this).hasClass('open')) {
                $(this).removeClass('open');
                $(this).next().slideUp("slow", function () {
                    $('.mb-body-left').animate({scrollTop: 0}, 500);

                });
            } else {
                var _this = this;

                allAccordions.slideUp("slow");
                allAccordionItems.removeClass('open');
                $(this).addClass('open');
                $(this).next().slideDown("slow", function () {
                    var pTop = $(_this).parents('.fltr').position().top,
                        eTop = $(_this).offset().top;

                    if (eTop < 0)
                        var top = Math.abs(pTop) - Math.abs(eTop);
                    else
                        var top = eTop + Math.abs(pTop);

                    $('.mb-body-left').animate({scrollTop: top}, 500);

                });
            }

            return false;
        });
    }

    return {
        init: init
    };

}(jQuery));

export default accordionMob;
