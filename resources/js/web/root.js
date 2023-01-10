// You can write a call and import your functions in this file.
//
// This file will be compiled into app.js
// Feel free with using ES6 here.

import "jquery-slimscroll"

import "./Products"
import "./modules/general"
import slider from "./modules/slider-home"
import backToTop from "./modules/backToTop"
import navMenu from "./modules/navMenu"
import filterMobile from "./modules/filterMobile"
import stickyHeader from "./modules/stickyHeader"
import sidebarMenu from "./modules/sidebarMenu"
import accordionMob from "./modules/accordionMob"
import slimScroll from "./modules/slimScroll"
import showSearchBlock from "./modules/showSearchBlock"
import cabinetShow from "./modules/cabinet-show"
import "./modules/stickySidebar"
import "./modules/cart"
import "./modules/putProductAside"
import "./modules/product-sliders"
import "./modules/orderPayment"
import "./modules/oembed"
import "./modules/contactForm"
;(($) => {
    // When DOM is ready
    $(() => {
        stickyHeader.init()
        slider.init()
        backToTop.init()
        navMenu.init()
        filterMobile.init()
        sidebarMenu.init()
        accordionMob.init()
        slimScroll.init()
        showSearchBlock.init()
        cabinetShow.init()
    })
})(jQuery)
