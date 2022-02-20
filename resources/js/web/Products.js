class Products {
    constructor() {
        this.cartItems = (window.cartItems || [])
            .map((item) => ({
                id: item.id,
                name: item.name,
                mainImage: item.mainImage,
                price_rub: item.price_rub,
                currency_rub_formatted: item.currency_rub_formatted,
                price_formatted: item.price_formatted,
                unit: item.unit,
                count: item.count,
                route: item.route,
                price_name: item.price_name,
                deleted_at: item.deleted_at,
            }))
            .reduce(this._cartItemsToMapReduceCB, {})
    }

    _cartItemsToMapReduceCB = (acc, item) => {
        acc[item.id] = {
            ...item,
        }
        return acc
    }

    _getAllCartItemsArray = () => Object.values(this.cartItems)

    getCartItemsMap = () =>
        this.getCartItems().reduce(this._cartItemsToMapReduceCB, {})

    getCartItemsWithTrashedMap = () =>
        this.getCartItemsWithTrashed().reduce(this._cartItemsToMapReduceCB, {})

    getCartItems = () =>
        this._getAllCartItemsArray().filter((item) => !item.deleted_at)

    getCartItemsWithTrashed = () => this._getAllCartItemsArray()

    getCartItemsCount = () =>
        this.getCartItems().reduce((acc, item) => (acc += item.count || 1), 0)

    getCartItemsWithTrashedCount = () =>
        this.getCartItemsWithTrashed().reduce(
            (acc, item) => (acc += item.count || 1),
            0
        )

    getCartItemsTotalPrice = () =>
        this.getCartItems().reduce(
            (acc, { price_rub, count }) => (acc += price_rub * count),
            0
        )

    getCartItemsWithTrashedTotalPrice = () =>
        this.getCartItemsWithTrashed().reduce(
            (acc, { price_rub, count }) => (acc += price_rub * count),
            0
        )

    getCartIds = () => this.getCartItems().map((id) => +id)

    getCartIdsWithTrashed = () =>
        this.getCartItemsWithTrashed().map((id) => +id)

    isInCart = (id) => typeof this.getCartItemsMap()[+id] !== "undefined"

    isInCartWithTrashed = (id) =>
        typeof this.getCartItemsWithTrashedMap()[+id] !== "undefined"

    find = (id) => this.getCartItemsMap()[+id]

    findWithTrashed = (id) => this.getCartItemsWithTrashedMap()[+id]

    setCartItems = (cartItems) => {
        this.cartItems = cartItems.reduce((acc, item) => {
            acc[item.id] = {
                ...item,
            }
            return acc
        }, {})
    }
}

const products = new Products()

// todo dev only
window.__products = products

export default products
