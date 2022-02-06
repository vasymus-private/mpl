import ajaxUrls from "../settings/ajaxUrls"
import Rest from "../../helpers/Rest"
import { formatErrorMessage } from "../../helpers/common"
;(function ($) {
    $().ready(() => {
        let $choosePaymentMethod = $(".js-choose-payment-method")
        let $describableSubmit = $(".js-describable-submit")
        let $error = $(".js-choose-payment-method-error")
        let paymentMethodItemSelector = ".js-payment-method-item"
        let paymentMethodDescriptionSelector = ".js-payment-method-description"
        let paymentMethodAttachmentsSelector = ".js-payment-method-attachment"

        if (!$choosePaymentMethod.length) {
            return true
        }

        $choosePaymentMethod.on("click", function (event) {
            let $el = $(event.target)
            let describable = !!+$el.data("describable")
            if (describable) {
                return true
            }

            let orderId = +$el.data("orderId")
            let paymentMethodId = +$el.data("id")

            Rest.POST(ajaxUrls.orderId(orderId), {
                order_id: orderId,
                payment_method_id: paymentMethodId,
            })
        })

        $describableSubmit.on("click", function (event) {
            event.preventDefault()
            let $el = $(event.target)
            let orderId = $el.data("orderId")
            let paymentMethodId = $el.data("id")
            let $item = $el.parents(paymentMethodItemSelector)
            let $description = $item.find(paymentMethodDescriptionSelector)
            let $attachment = $item.find(paymentMethodAttachmentsSelector)

            let data = new FormData()
            data.append("order_id", orderId)
            data.append("payment_method_id", paymentMethodId)
            data.append("payment_method_description", $description.val())

            let files = $attachment[0].files
            for (let i = 0; i < files.length; i++) {
                data.append("attachment[]", files[i])
            }

            fetch(ajaxUrls.orderId(orderId), {
                method: "POST",
                headers: Rest.getFilesHeaders(),
                body: data,
            })
                .then((response) => {
                    if (response.status >= 400) {
                        throw new Error(
                            formatErrorMessage(response, response.statusText)
                        )
                    }
                    return response.json()
                })
                .then((result) => {
                    let { url } = result
                    if (url) {
                        window.location = url
                        return true
                    }
                    window.location = `${window.location.origin}/profile`
                })
                .catch((error) => {
                    $error.text(error.message)
                    console.warn(error)
                })
        })
    })
})(jQuery)
