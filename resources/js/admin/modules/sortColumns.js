import Sortable from "sortablejs"

function init(id) {
    let sortable = document.getElementById(id)
    if (!sortable) {
        return
    }
    new Sortable(sortable, {
        animation: 150,
        ghostClass: "blue-background-class",
    })

    window.getColumnsSorted = (id) => {
        let values = []
        $(`#${id}`)
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
}

export {
    init,
}
