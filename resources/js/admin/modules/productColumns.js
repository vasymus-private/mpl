import Sortable from "sortablejs"

;(() => {
    let productColumnsSortable = document.getElementById(
        "product-columns-sortable"
    )
    if (!productColumnsSortable) {
        return
    }
    new Sortable(productColumnsSortable, {
        animation: 150,
        ghostClass: "blue-background-class",
    })

    window.getProductColumnsSortable = () => {
        let values = []
        $(productColumnsSortable)
            .children()
            .each((i, el) => {
                let value = $(el).data("value")
                if (!value) {
                    return
                }
                values = [...values, value]
            })
        return values
    }
})()
