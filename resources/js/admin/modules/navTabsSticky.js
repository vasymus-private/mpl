(() => {
    let wrapperSelector = '.js-nav-tabs-wrapper'
    let navSelector = '.js-nav-tabs'
    let markerSelector = '.js-nav-tabs-marker'
    let fixedClass = 'nav-tabs-fixed'

    let $window = $(window)
    let $wrappers = $(wrapperSelector)

    $wrappers.each((i, el) => {
        let $wrapper = $(el)
        let $nav = $wrapper.find(navSelector)
        let $marker = $wrapper.find(markerSelector)

        main()

        $('[data-toggle="tab"]').on('shown.bs.tab', () => {
            main()
        })

        $window.on('scroll', () => {
            main()
        })

        function main() {
            let isVisible = getIsVisible()
            if (isVisible) {
                $nav.removeClass(fixedClass)
                return true
            }

            $nav.addClass(fixedClass)
        }

        function getIsVisible() {
            let top = $marker.offset().top
            let scrollTop = $window.scrollTop()

            return top > scrollTop
        }
    })
})()
