import { defineStore } from "pinia"

const storeName = "ordersStore"

interface State {
    _entities: Array<OrderItem>
    _entity: Order | null
}

const useOrdersStore = defineStore(storeName, {
    state(): State {
        return {
            _entities: [],
            _entity: null,
        }
    },
})
