import { defineStore } from "pinia"
import { OrderItem, Order } from "@/admin/inertia/modules/orders/types"
import Links from "@/admin/inertia/modules/common/Links"
import Meta from "@/admin/inertia/modules/common/Meta"
import { useRoutesStore } from "@/admin/inertia/modules/routes"
import { extendMetaLinksWithComputedData } from "@/admin/inertia/modules/common"
import { DateTime } from "luxon"

const storeName = "ordersStore"

interface State {
    _entities: Array<OrderItem>
    _links: Links | null
    _meta: Meta | null
    _entity: Order | null
}

export const useOrdersStore = defineStore(storeName, {
    state(): State {
        return {
            _entities: [],
            _links: null,
            _meta: null,
            _entity: null,
        }
    },
    getters: {
        ordersList(state): Array<OrderItem> {
            return state._entities
        },
    },
    actions: {
        setOrdersList(ordersList: Array<OrderItem>): void {
            this._entities = ordersList.map((item) => ({
                ...item,
                dt_created_at: item.created_at
                    ? DateTime.fromFormat(
                          item.created_at,
                          "YYYY-MM-DD HH:mm:ss"
                      )
                    : null,
            }))
        },
        setLinks(links: Links | null): void {
            this._links = links
        },
        setMeta(meta: Meta | null): void {
            const routesStore = useRoutesStore()
            this._meta = meta
                ? extendMetaLinksWithComputedData(meta, routesStore.fullUrl)
                : null
        },
        setOrder(order: Order | null): void {
            if (!order) {
                this._entity = order
                return
            }
            this._entity = {
                ...order,
                dt_created_at: order.created_at
                    ? DateTime.fromFormat(
                          order.created_at,
                          "YYYY-MM-DD HH:mm:ss"
                      )
                    : null,
                dt_updated_at: order.updated_at
                    ? DateTime.fromFormat(
                          order.updated_at,
                          "YYYY-MM-DD HH:mm:ss"
                      )
                    : null,
            }
        },
    },
})
