const PRODUCTS_ASIDE_PAGE_CONTENT_WRAPPER_CLASS = "js-page-content-wrapper-aside"
export const PRODUCT_HOVER_ON_POPOVER_CLASS = "js-product-item-popover"

export const getAddToCartInputCountClass = id => `js-add-to-cart-input-count-${id}`

export const getProductItemComponentClass = id => `js-product-item-component-${id}`

export const isProductsAsidePage = () => getProductsAsidePageContentWrapper().length > 0

export const getProductsAsidePageContentWrapper = () => jQuery(`.${PRODUCTS_ASIDE_PAGE_CONTENT_WRAPPER_CLASS}`)

export const getProductsHoverOnPopover = () => jQuery(`.${PRODUCT_HOVER_ON_POPOVER_CLASS}`)
