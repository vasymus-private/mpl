;(function ($) {
    $().ready(() => {
        let $successContactFormModal = $("#success-contact-form")
        let $modalContactWithTechnologist = $("#contact-with-technologist")

        if (window.___successContactForm) {
            $.fancybox.open($successContactFormModal)
        }

        if (window.___failedRequestTechnologist) {
            $.fancybox.open($modalContactWithTechnologist)
        }
    })
})(jQuery)
