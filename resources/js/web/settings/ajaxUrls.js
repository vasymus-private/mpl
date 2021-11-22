const prefix = "ajax"

const ajaxUrls = {
    putProductAside : `/${prefix}/products/aside`,
    productInCart : `/${prefix}/products/cart`,
    orderId : (id) => `/${prefix}/orders/${id}`,
}

export default ajaxUrls
