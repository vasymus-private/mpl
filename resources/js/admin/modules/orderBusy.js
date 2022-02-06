import Rest from "../../helpers/Rest"
;(() => {
    handleMarkers()

    function handleMarkers() {
        let isBusyHtml = `<span style="display: inline-block; width: 20px; height: 20px; background-color: red; border-radius: 100%;"></span>`
        let isNotBusyHtml = `<span style="display: inline-block; width: 20px; height: 20px; background-color: green; border-radius: 100%;"></span>`

        setInterval(() => {
            console.log("--- sync order busy markers ---")
            let $orderBusyMarkerWrapper = $(".js-order-busy-marker-wrapper")
            if (!$orderBusyMarkerWrapper.length) {
                return
            }
            let $markers = $orderBusyMarkerWrapper.find(".js-order-busy-marker")

            let ids = []
            $markers.each((i, el) => {
                let id = $(el).data("id")
                if (!id) {
                    return
                }
                ids = [...ids, id]
            })
            if (!ids.length) {
                return
            }

            Rest.POST("/admin-ajax/show-order-busy", {
                ids,
            })
                .then(Rest.middleThen)
                .then((response) => {
                    let { data = [] } = response
                    if (!data.length) {
                        return
                    }
                    data.forEach((item) => {
                        let { id, is_busy_by_other_admin } = item
                        let $marker = $orderBusyMarkerWrapper.find(
                            `.js-order-busy-marker-${id}`
                        )
                        if (!$marker.length) {
                            return
                        }
                        if (is_busy_by_other_admin) {
                            $marker.html(isBusyHtml)
                            return
                        }
                        $marker.html(isNotBusyHtml)
                    })
                })
        }, 30 * 1000)
    }

    window.handlePingOrderBusy = (id) => {
        pingOrderBusy(id)
        setInterval(() => {
            pingOrderBusy(id)
        }, 30 * 1000)
    }

    function pingOrderBusy(id) {
        console.log("--- ping order busy ---")
        Rest.POST(`/admin-ajax/ping-order-busy/${id}`)
            .then(Rest.middleThen)
            .catch(Rest.simpleCatch)
    }
})()
