import Sortable from "sortablejs"

function init(id) {
    if (!document.getElementById(id)) {
        return
    }
    new Sortable(document.getElementById(id), {
        animation: 150,
        ghostClass: "blue-background-class",
    })

    window.getColumnsSorted = (id) => {
        let values = []
        $(document.getElementById(id))
            .children()
            .each((i, el) => {
                let value = $(el).data("value")
                let label = $(el).text()
                if (!value) {
                    return
                }
                values = [...values, value]
            })

        return [...new Set(values)]
    }
}

export { init }
