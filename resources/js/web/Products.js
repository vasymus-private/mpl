import {arrayPrimitivesToObj} from '../helpers/common'


class Products {
    constructor() {
        this.cartIds = arrayPrimitivesToObj(window.cartIds || [], 1)
        this.cartItems = []
    }

    getCartIds = () => Object.keys(this.cartIds).map(id => +id)

    isInCart = id => typeof this.cartIds[id] !== "undefined"

    addToCartIds = id => {
        if (typeof id === "undefined") return

        this.cartIds = {...this.cartIds, [id] : 1}
    }

    removeFromCartIds = id => {
        let {[id] : omit, ...rest} = this.cartIds
        this.cartIds = {...rest}
    }

    setCartIds = (ids = []) => {
        this.cartIds = arrayPrimitivesToObj(ids, 1)
    }
}

const products = new Products()

// todo dev only
window.__products = products

export default products
