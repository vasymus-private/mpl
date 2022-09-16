import { defineStore } from "pinia"
import {OrderItem, Order} from "@/admin/inertia/modules/orders/types"
import Links from "@/admin/inertia/modules/common/Links"
import Meta from "@/admin/inertia/modules/common/Meta"

const storeName = "ordersStore"

interface State {
    _entities: Array<OrderItem>
    _links: Links | null
    _meta: Meta | null
    _entity: Order | null
}

const useOrdersStore = defineStore(storeName, {
    state(): State {
        return {
            _entities: [],
            _links: null,
            _meta: null,
            _entity: null,
        }
    },
})
