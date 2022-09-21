import { defineStore } from "pinia"
import {
    Order,
    OrderItem,
    OrderItemProductItem,
    OrderProductItem,
} from "@/admin/inertia/modules/orders/types"
import Links from "@/admin/inertia/modules/common/Links"
import Meta from "@/admin/inertia/modules/common/Meta"
import { useRoutesStore } from "@/admin/inertia/modules/routes"
import { extendMetaLinksWithComputedData } from "@/admin/inertia/modules/common"
import { DateTime } from "luxon"
import { useCurrenciesStore } from "@/admin/inertia/modules/currencies"
import { CharCode } from "@/admin/inertia/modules/currencies/types"
import Option from "@/admin/inertia/modules/common/Option"

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
        orderPriceRetailRub(state) {
            return (id: number): number | null => {
                let order: Order | OrderItem
                if (state._entity?.id === id) {
                    order = state._entity
                } else {
                    order = this.ordersList.find(
                        (item: OrderItem) => item.id === id
                    )
                }

                if (!order) {
                    return null
                }

                let orderProducts: Array<
                    OrderProductItem | OrderItemProductItem
                > = order.products

                return orderProducts.reduce<number>(
                    (
                        acc: number,
                        product: OrderItemProductItem | OrderProductItem
                    ): number => {
                        return (
                            acc +
                            product.order_product.price_retail_rub *
                                product.order_product.count
                        )
                    },
                    0
                )
            }
        },
        orderPriceRetailRubFormatted() {
            return (id: number): string => {
                let sumOrderProductsPriceRub: number | null =
                    this.orderPriceRetailRub(id)

                if (!sumOrderProductsPriceRub) {
                    return ""
                }

                const currenciesStore = useCurrenciesStore()

                return currenciesStore.priceRubFormatted(
                    sumOrderProductsPriceRub,
                    CharCode.RUB
                )
            }
        },
        links: (state: State): Links | null => state._links,
        meta: (state: State): Meta | null => state._meta,
        getPerPageOption: (state: State): Option | null =>
            state._meta && state._meta.per_page
                ? {
                      value: state._meta.per_page,
                      label: `${state._meta.per_page}`,
                  }
                : null,
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
