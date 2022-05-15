;(($) => {
    $(() => {
        //require('./modules/tinymce')
        // require('./modules/quill')
        require("./modules/ckeditor4")
        require("./modules/sidebar")
        require("./modules/orderBusy")

        let columnSorting = require('./modules/sortColumns')
        columnSorting.init('product-columns-sortable');
        columnSorting.init('order-columns-sortable');
        columnSorting.init('product-variant-columns-sortable')

        require("./modules/navTabsSticky")
        require("./modules/footerSticky")
    })
})(jQuery)
