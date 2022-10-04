import { defineStore } from "pinia"
import {
    Order, OrderEvent,
    OrderItem,
    OrderItemProductItem,
    OrderProductItem,
} from "@/admin/inertia/modules/orders/types"
import Links from "@/admin/inertia/modules/common/Links"
import Meta from "@/admin/inertia/modules/common/Meta"
import {getRouteUrl, routeNames, useRoutesStore} from "@/admin/inertia/modules/routes"
import {errorsToErrorFields, extendMetaLinksWithComputedData} from "@/admin/inertia/modules/common"
import { DateTime } from "luxon"
import { useCurrenciesStore } from "@/admin/inertia/modules/currencies"
import { CharCode } from "@/admin/inertia/modules/currencies/types"
import Option from "@/admin/inertia/modules/common/Option"
import {ErrorResponse, UrlParams} from "@/admin/inertia/modules/common/types"
import axios, {AxiosError} from "axios";
import {useToastsStore} from "@/admin/inertia/modules/toasts";

const storeName = "orders"
const format = "yyyy-LL-dd HH:mm:ss"

interface State {
    _entities: Array<OrderItem>
    _links: Links | null
    _meta: Meta | null
    _entity: Order | null
    _orderEvents: Array<OrderEvent>
}

export const useOrdersStore = defineStore(storeName, {
    state(): State {
        return {
            _entities: [],
            _links: null,
            _meta: null,
            _entity: null,
            _orderEvents: [],
        }
    },
    getters: {
        ordersList: (state): Array<OrderItem> => state._entities,
        order: (state): Order | null => state._entity,
        orderEvents: (state): Array<OrderEvent> => state._orderEvents,
        isCreatingOrderRoute() {
            let routesStore = useRoutesStore()

            return [
                routeNames.ROUTE_ADMIN_ORDERS_CREATE,
                routeNames.ROUTE_ADMIN_ORDERS_TEMP_CREATE,
            ].includes(routesStore.current)
        },
        isCreatingFromCopy(): boolean {
            if (!this.isCreatingOrderRoute) {
                return false
            }

            const routesStore = useRoutesStore()

            return routesStore.hasUrlParam(UrlParams.copy_id)
        },
        orderItemPriceRetailRubFormatted() {
            return (id: number): string => {
                let order: OrderItem | undefined = this.ordersList.find(
                    (item: OrderItem) => item.id === id
                )

                if (!order) {
                    return ""
                }

                let sumOrderProductsPriceRub: number =
                    order.products.reduce<number>(
                        (
                            acc: number,
                            product: OrderItemProductItem
                        ): number => {
                            return (
                                acc +
                                product.order_product_price_retail_rub *
                                    product.order_product_count
                            )
                        },
                        0
                    )

                const currenciesStore = useCurrenciesStore()

                return currenciesStore.priceRubFormatted(
                    sumOrderProductsPriceRub,
                    CharCode.RUB
                )
            }
        },
        orderProductItem() {
            return (productUuid: string): OrderProductItem | undefined => {
                return this.order?.products.find(
                    (item) => item.uuid === productUuid
                )
            }
        },
        orderProductItemPricePurchaseRubFormatted() {
            return (productUuid: string): string | null => {
                let orderProductItem: OrderProductItem | undefined =
                    this.orderProductItem(productUuid)
                if (!orderProductItem) {
                    return null
                }

                const currenciesStore = useCurrenciesStore()

                return currenciesStore.priceRubFormatted(
                    orderProductItem.price_purchase,
                    orderProductItem.price_purchase_currency_id
                )
            }
        },
        orderProductItemPricePurchaseRubSum() {
            return (productUuid: string): number | null => {
                let orderProductItem: OrderProductItem | undefined =
                    this.orderProductItem(productUuid)
                if (!orderProductItem) {
                    return null
                }

                const currenciesStore = useCurrenciesStore()

                let pricePurchase = currenciesStore.priceRub(
                    orderProductItem.price_purchase,
                    orderProductItem.price_purchase_currency_id
                )

                return pricePurchase * orderProductItem.order_product_count
            }
        },
        orderProductItemPricePurchaseRubSumFormatted() {
            return (productUuid: string): string | null => {
                const rubPurchaseSum: number | null =
                    this.orderProductItemPricePurchaseRubSum(productUuid)

                if (!rubPurchaseSum) {
                    return null
                }

                const currenciesStore = useCurrenciesStore()

                return currenciesStore.priceRubFormatted(
                    rubPurchaseSum,
                    CharCode.RUB
                )
            }
        },
        orderProductItemPriceRetailRubSum() {
            return (productUuid: string): number | null => {
                let orderProductItem: OrderProductItem | undefined =
                    this.orderProductItem(productUuid)
                if (!orderProductItem) {
                    return null
                }

                return (
                    orderProductItem.order_product_price_retail_rub *
                    orderProductItem.order_product_count
                )
            }
        },
        orderProductItemPriceRetailRubSumFormatted() {
            return (productUuid: string): string => {
                const rubRetailSum: number | null =
                    this.orderProductItemPriceRetailRubSum(productUuid)

                const currenciesStore = useCurrenciesStore()

                return currenciesStore.priceRubFormatted(
                    rubRetailSum,
                    CharCode.RUB
                )
            }
        },
        orderProductItemProfitRubFormatted() {
            return (productUuid: string): string | null => {
                const rubPurchaseSum: number | null =
                    this.orderProductItemPricePurchaseRubSum(productUuid)
                const rubRetailSum: number | null =
                    this.orderProductItemPriceRetailRubSum(productUuid)

                const profitRub = rubRetailSum - rubPurchaseSum
                const currenciesStore = useCurrenciesStore()

                return currenciesStore.priceRubFormatted(
                    profitRub,
                    CharCode.RUB
                )
            }
        },
        orderTotalPriceRetailRub(): number {
            return this.order?.products.reduce(
                (acc: number, orderProductItem: OrderProductItem): number => {
                    return (
                        acc +
                        this.orderProductItemPriceRetailRubSum(
                            orderProductItem.uuid
                        )
                    )
                },
                0
            )
        },
        orderTotalPriceRetailRubFormatted(): string {
            const currenciesStore = useCurrenciesStore()

            return currenciesStore.priceRubFormatted(
                this.orderTotalPriceRetailRub,
                CharCode.RUB
            )
        },
        orderTotalPricePurchaseRub(): number {
            return this.order?.products.reduce(
                (acc: number, orderProductItem: OrderProductItem): number => {
                    return (
                        acc +
                        this.orderProductItemPricePurchaseRubSum(
                            orderProductItem.uuid
                        )
                    )
                },
                0
            )
        },
        orderTotalPricePurchaseRubFormatted(): string {
            const currenciesStore = useCurrenciesStore()

            return currenciesStore.priceRubFormatted(
                this.orderTotalPricePurchaseRub,
                CharCode.RUB
            )
        },
        orderTotalProfitRub(): number {
            return (
                this.orderTotalPriceRetailRub - this.orderTotalPricePurchaseRub
            )
        },
        orderTotalProfitRubFormatted(): string {
            const currenciesStore = useCurrenciesStore()

            return currenciesStore.priceRubFormatted(
                this.orderTotalProfitRub,
                CharCode.RUB
            )
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
                    ? DateTime.fromFormat(item.created_at, format)
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
                    ? DateTime.fromFormat(order.created_at, format)
                    : null,
                dt_updated_at: order.updated_at
                    ? DateTime.fromFormat(order.updated_at, format)
                    : null,
            }
        },
        setOrderEvents(orderEvents: Array<OrderEvent>): void {
            this._orderEvents = orderEvents.map(item => ({
                ...item,
                dt_created_at: item.created_at
                    ? DateTime.fromFormat(item.created_at, format)
                    : null,
            }))
        },
        async fetchOrderEvents(): Promise<void> {
            if (!this._entity) {
                return
            }

            try {
                const response = await axios.get<{data: Array<OrderEvent>}>(getRouteUrl(routeNames.ROUTE_ADMIN_AJAX_ORDER_EVENTS_INDEX, {admin_order: this._entity.id}))

                this.setOrderEvents(response.data.data)
            } catch (e) {
                if (e instanceof AxiosError) {
                    const toastsStore = useToastsStore()

                    const {
                        data: { errors },
                    }: ErrorResponse = e.response

                    const errs = errorsToErrorFields(errors)

                    for (let key in errs) {
                        toastsStore.error({
                            title: key,
                            message: errs[key]
                        })
                    }
                }

                throw e
            }
        },
        updateOrder(order: Partial<Order>): void {
            this._entity = {
                ...this._entity,
                ...order,
                dt_updated_at: order.updated_at
                    ? DateTime.fromFormat(order.updated_at, format)
                    : null,
            }
        },
    },
})
