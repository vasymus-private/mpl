;(() => {
    let wrapperSelector = ".js-edit-footer-wrapper"
    let footerSelector = ".js-edit-item-footer"
    let fixedClass = "edit-item-footer-fixed"
    let pinButtonSelector = ".js-pin-btn"
    let pinButtonPinnedClass = "pin-btn-pinned"
    let footerMarkerSelector = ".js-edit-item-footer-marker"

    let $window = $(window)
    let $wrappers = $(wrapperSelector)

    $wrappers.each((i, el) => {
        let $wrapper = $(el)
        let $btn = $wrapper.find(pinButtonSelector)
        let $footer = $wrapper.find(footerSelector)
        let $marker = $wrapper.find(footerMarkerSelector)
        let isPinned = true

        setIsPinned(isPinned)
        main()

        $btn.on("click", () => {
            toggleIsPinned()
        })

        $('[data-toggle="tab"]').on("shown.bs.tab", () => {
            main()
        })

        $window.on("scroll", () => {
            main()
        })

        function main() {
            if (!getIsPinned()) {
                return true
            }

            let isVisible = getIsVisible()
            if (isVisible) {
                $footer.removeClass(fixedClass)
                return true
            }

            $footer.addClass(fixedClass)
        }

        function getIsPinned() {
            return isPinned
        }

        function toggleIsPinned() {
            setIsPinned(!getIsPinned())
        }

        function setIsPinned(_isPinned) {
            isPinned = _isPinned
            if (!_isPinned) {
                $btn.removeClass(pinButtonPinnedClass)
                $footer.removeClass(fixedClass)
                return
            }
            $btn.addClass(pinButtonPinnedClass)
        }

        function getIsVisible() {
            let footerTop = $marker.offset().top
            let scrollTop = $window.scrollTop()
            let space = $window.height() - $footer.height()

            let compare = scrollTop + space + 20

            return footerTop < compare
        }
    })
})()
