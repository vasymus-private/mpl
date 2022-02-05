import Rest from "../../helpers/Rest"

;(() => {
    $(".js-navigate-categories").on("click", (event) => {
        event.stopPropagation()
        event.preventDefault()
        let $currentTarget = $(event.currentTarget)
        let route = $currentTarget.data("route")

        if (!route) {
            return true
        }

        location.href = route
    })

    const resizer = document.querySelector("#resizer")
    const sidebar = document.querySelector("#aside")

    let isClicked = false
    let currentFlexBasis

    resizer.addEventListener("mousedown", (event) => {
        isClicked = true
    })

    document.addEventListener("mousemove", resize, false)
    document.addEventListener(
        "mouseup",
        () => {
            isClicked = false
            if (currentFlexBasis) {
                Rest.PUT(`/admin-ajax/profiles/1`, {
                    adminSidebarFlexBasis: currentFlexBasis,
                })
            }
        },
        false
    )

    function resize(e) {
        if (isClicked) {
            currentFlexBasis = sidebar.style.flexBasis = `${e.x}px`
            if (window.getSelection) {
                if (window.getSelection().empty) {
                    // Chrome
                    window.getSelection().empty()
                } else if (window.getSelection().removeAllRanges) {
                    // Firefox
                    window.getSelection().removeAllRanges()
                }
            } else if (document.selection) {
                // IE?
                document.selection.empty()
            }
        }
    }
})()
