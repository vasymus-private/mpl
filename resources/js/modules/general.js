jQuery().ready(() => {
    //jQuery('.js-form-select-autosubmit').on('')

    jQuery('.js-back').on('click', event => {
        event.preventDefault()
        window.history.go(-1)
    })
})
