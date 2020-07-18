let showSearchBlock = (function ($) {
    'use strict';

    function init() {
        $('.sidebar-catalog__search-icon').on('click', () => {
            $('.js-search-event').toggle();
        })
    }

    return {
        init: init
    };

}(jQuery));

export default showSearchBlock;
