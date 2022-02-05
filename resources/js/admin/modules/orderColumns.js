import Sortable from "sortablejs"

;(() => {
    let orderColumnsSortable = document.getElementById("order-columns-sortable")
    if (!orderColumnsSortable) {
        return
    }
    new Sortable(orderColumnsSortable, {
        animation: 150,
        ghostClass: "blue-background-class",
    })

    window.getOrderColumnsSorted = () => {
        let values = []
        $(orderColumnsSortable)
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
