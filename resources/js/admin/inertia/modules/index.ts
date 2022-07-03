import Column from "@/admin/inertia/modules/columns/Column"
import Article from "@/admin/inertia/modules/articles/Article"
import Auth from "@/admin/inertia/modules/auth/Auth"
import Option from "@/admin/inertia/modules/common/Option"
import CategoryTreeItem from "@/admin/inertia/modules/categoriesTree/CategoryTreeItem"
import { useAuthStore } from "@/admin/inertia/modules/auth"
import { Pinia } from "pinia"
import { useArticlesStore } from "@/admin/inertia/modules/articles"
import { Service } from "@/admin/inertia/modules/services/Service"
import { useServicesStore } from "@/admin/inertia/modules/services"
import { useCategoriesTreeStore } from "@/admin/inertia/modules/categoriesTree"
import { useColumnsStore } from "@/admin/inertia/modules/columns"
import { useBrandsStore } from "@/admin/inertia/modules/brands"
import ProductListItem from "@/admin/inertia/modules/products/ProductListItem"
import { useProductsStore } from "@/admin/inertia/modules/products"
import AvailabilityStatus from "@/admin/inertia/modules/availabilityStatuses/AvailabilityStatus"
import { useAvailabilityStatusesStore } from "@/admin/inertia/modules/availabilityStatuses"
import BillStatus from "@/admin/inertia/modules/billStatuses/BillStatus"
import { useBillStatusesStore } from "@/admin/inertia/modules/billStatuses"
import Currency from "@/admin/inertia/modules/currencies/Currency"
import { useCurrenciesStore } from "@/admin/inertia/modules/currencies"
import PaymentMethod from "@/admin/inertia/modules/paymentMethods/PaymentMethod"
import { usePaymentMethodsStore } from "@/admin/inertia/modules/paymentMethods"
import OrderImportance from "@/admin/inertia/modules/orderImportance/OrderImportance"
import { useOrderImportanceStore } from "@/admin/inertia/modules/orderImportance"
import OrderStatus from "@/admin/inertia/modules/orderStatuses/OrderStatus"
import { useOrderStatusesStore } from "@/admin/inertia/modules/orderStatuses"
import CharType from "@/admin/inertia/modules/chars/CharType"
import { useCharsStore } from "@/admin/inertia/modules/chars"

/**
 * props on all page + props specific for concrete controller
 * @see \App\Http\Middleware\HandleInertiaRequests::share()
 */
export const initFromPageProps = (pinia: Pinia, initialPageProps) => {
    let {
        adminOrderColumns = [],
        adminProductColumns = [],
        adminProductVariantColumns = [],
        articles = [],
        auth,
        brandOptions = [],
        categoriesTree = [],
        services = [],
        productListItems = [],
        availabilityStatuses = [],
        billStatuses = [],
        currencies = [],
        paymentMethods = [],
        orderImportance = [],
        orderStatuses = [],
        charTypes = [],
    }: {
        adminOrderColumns: Array<Column>
        adminProductColumns: Array<Column>
        adminProductVariantColumns: Array<Column>
        articles: Array<Article>
        auth: Auth
        brandOptions: Array<Option>
        categoriesTree: Array<CategoryTreeItem>
        services: Array<Service>
        productListItems: Array<ProductListItem>
        availabilityStatuses: Array<AvailabilityStatus>
        billStatuses: Array<BillStatus>
        currencies: Array<Currency>
        paymentMethods: Array<PaymentMethod>
        orderImportance: Array<OrderImportance>
        orderStatuses: Array<OrderStatus>
        charTypes: Array<CharType>
    } = initialPageProps

    const authStore = useAuthStore(pinia)
    authStore.setAuthUser(auth.user)

    const articlesStore = useArticlesStore(pinia)
    articlesStore.setEntities(articles)

    const servicesStore = useServicesStore(pinia)
    servicesStore.setEntities(services)

    const categoriesTreeStore = useCategoriesTreeStore(pinia)
    categoriesTreeStore.setEntities(categoriesTree)

    const columnsStore = useColumnsStore(pinia)
    columnsStore.setAdminOrderColumns(adminOrderColumns)
    columnsStore.setAdminProductColumns(adminProductColumns)
    columnsStore.setAdminProductVariantColumns(adminProductVariantColumns)

    const brandsStore = useBrandsStore(pinia)
    brandsStore.setOptions(brandOptions)

    const productsStore = useProductsStore(pinia)
    productsStore.setProductListItems(productListItems)

    const availabilityStatusesStore = useAvailabilityStatusesStore(pinia)
    availabilityStatusesStore.setEntities(availabilityStatuses)

    const billStatusesStore = useBillStatusesStore(pinia)
    billStatusesStore.setEntities(billStatuses)

    const currenciesStore = useCurrenciesStore(pinia)
    currenciesStore.setEntities(currencies)

    const paymentMethodsStore = usePaymentMethodsStore(pinia)
    paymentMethodsStore.setEntities(paymentMethods)

    const orderImportanceStore = useOrderImportanceStore(pinia)
    orderImportanceStore.setEntities(orderImportance)

    const orderStatusesStore = useOrderStatusesStore(pinia)
    orderStatusesStore.setEntities(orderStatuses)

    const charsStore = useCharsStore(pinia)
    charsStore.setChartTypes(charTypes)
}
