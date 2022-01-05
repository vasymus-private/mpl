$('.js-navigate-categories').on('click', event => {
    event.stopPropagation()
    event.preventDefault()
    let $currentTarget = $(event.currentTarget)
    let route = $currentTarget.data('route')

    if (!route) {
        return true
    }

    location.href = route
})
