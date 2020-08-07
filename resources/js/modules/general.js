jQuery().ready(() => {
    //jQuery('.js-form-select-autosubmit').on('')

    jQuery('.js-back').on('click', event => {
        event.preventDefault()
        window.history.go(-1)
    })

    let $productItems = jQuery(".js-product-item-popover")

    $productItems.each((ind, el) => {
        let $productItem = $(el)
        $productItem.popover({
            container : "body",
            html : true,
            placement : "right",
            template : '<div class="popover" role="tooltip"><div class="arrow"></div><button type="button" class="popover-close js-product-item-popover-close" style="position: absolute; top: 0; right: 0">X</button><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
            trigger : "manual",
            sanitize : false,
            title : "&nbsp;",
        })

        $productItem.on("shown.bs.popover", event => {
            let $target = jQuery(event.target)
            let $popup = jQuery(`#${$target.attr('aria-describedby')}`)
            $popup.find(".js-product-item-popover-close").on("click", ev => {
                $productItem.popover("hide")
            })
        })

        $productItem.popover("show")
    })



})
