// TODO move to Products.js

const PRODUCTS_ASIDE_PAGE_CONTENT_WRAPPER_CLASS =
    "js-page-content-wrapper-aside"
export const PRODUCT_HOVER_ON_POPOVER_CLASS = "js-product-item-popover"
const CART_DELETE_CLASS = "js-cart-delete"
const CART_ROW_CLASS = "js-cart-row"

export const getAddToCartInputCountClass = (id) =>
    `js-add-to-cart-input-count-${id}`

export const getCartRows$ = () => jQuery(`.${CART_ROW_CLASS}`)
export const getCartRow$ = (id) => getCartRows$().filter(`[data-id=${id}]`)

export const getCartColumnCountPartNormals$ = () =>
    jQuery(`.js-cart-column-count-part-normal`)
export const getCartColumnCountPartNormal$ = (id) =>
    getCartColumnCountPartNormals$().filter(`[data-id=${id}]`)

export const getCartColumnCountPartDeleteds$ = () =>
    jQuery(`.js-cart-column-count-part-deleted`)
export const getCartColumnCountPartDeleted$ = (id) =>
    getCartColumnCountPartDeleteds$().filter(`[data-id=${id}]`)

export const getProductItemComponentClass = (id) =>
    `js-product-item-component-${id}`

export const isProductsAsidePage = () =>
    getProductsAsidePageContentWrapper().length > 0

export const getProductsAsidePageContentWrapper = () =>
    jQuery(`.${PRODUCTS_ASIDE_PAGE_CONTENT_WRAPPER_CLASS}`)

export const getProductsHoverOnPopover = () =>
    jQuery(`.${PRODUCT_HOVER_ON_POPOVER_CLASS}`)

export const getCartItemSumFormatted$ = (id) =>
    jQuery(`.js-cart-item-sum-formatted`).filter(`[data-id=${id}]`)

export const getCartDeletes$ = () => jQuery(`.${CART_DELETE_CLASS}`)
export const getCartDelete$ = (id) =>
    getCartDeletes$().filter(`[data-id=${id}]`)

export const getAddToCartPopoverClass = (id) => `js-add-to-cart-popover-${id}`
export const getAddToCartPopover$ = (id) =>
    jQuery(`.${getAddToCartPopoverClass(id)}`)
