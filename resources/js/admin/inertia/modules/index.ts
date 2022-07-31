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
import Currency, { Rate } from "@/admin/inertia/modules/currencies/Currency"
import { useCurrenciesStore } from "@/admin/inertia/modules/currencies"
import PaymentMethod from "@/admin/inertia/modules/paymentMethods/PaymentMethod"
import { usePaymentMethodsStore } from "@/admin/inertia/modules/paymentMethods"
import OrderImportance from "@/admin/inertia/modules/orderImportance/OrderImportance"
import { useOrderImportanceStore } from "@/admin/inertia/modules/orderImportance"
import OrderStatus from "@/admin/inertia/modules/orderStatuses/OrderStatus"
import { useOrderStatusesStore } from "@/admin/inertia/modules/orderStatuses"
import CharType from "@/admin/inertia/modules/charTypes/CharType"
import { useCharTypesStore } from "@/admin/inertia/modules/charTypes"
import Links from "@/admin/inertia/modules/common/Links"
import Meta from "@/admin/inertia/modules/common/Meta"
import { useRoutesStore } from "@/admin/inertia/modules/routes"
import Product from "@/admin/inertia/modules/products/Product"

interface InitialPageProps {
    fullUrl: string
    auth: Auth
    categoriesTree: Array<CategoryTreeItem>
    brandOptions: Array<Option>
    adminOrderColumns: Array<Column>
    adminProductColumns: Array<Column>
    adminProductVariantColumns: Array<Column>
    availabilityStatuses: { data: Array<AvailabilityStatus> }
    billStatuses: { data: Array<BillStatus> }
    currencies: { data: Array<Currency> }
    currencyTodayRate: Array<Rate>
    paymentMethods: { data: Array<PaymentMethod> }
    orderImportance: { data: Array<OrderImportance> }
    orderStatuses: { data: Array<OrderStatus> }
    charTypes: { data: Array<CharType> }

    articles?: Array<Article>
    services?: Array<Service>
    productListItems?: {
        data: Array<ProductListItem>
        links: Links
        meta: Meta
    }
    product?: Product
    originProduct?: Product
}

/**
 * props on all page + props specific for concrete controller
 * @see \App\Http\Middleware\HandleInertiaRequests::share()
 */
export const initFromPageProps = (pinia: Pinia, initialPageProps) => {
    let {
        fullUrl,
        auth,
        categoriesTree = [],
        brandOptions = [],
        adminOrderColumns = [],
        adminProductColumns = [],
        adminProductVariantColumns = [],
        availabilityStatuses: { data: availabilityStatusesData = [] },
        billStatuses: { data: billStatusesData = [] },
        currencies: { data: currenciesData = [] },
        currencyTodayRate = [],
        paymentMethods: { data: paymentMethodsData = [] },
        orderImportance: { data: orderImportanceData = [] },
        orderStatuses: { data: orderStatusesData = [] },
        charTypes: { data: charTypesData = [] },

        articles = [],
        services = [],
        productListItems: {
            data: productListItemsData = [],
            links: productListItemsLinks = null,
            meta: productListItemsMeta = null,
        } = {},
        product = null,
        originProduct = null,
    } = initialPageProps as InitialPageProps

    // todo dev only
    if (typeof window !== "undefined") {
        // @ts-ignore
        window.__initialPageProps = initialPageProps
    }

    const routesStore = useRoutesStore(pinia)
    routesStore.setFullUrl(fullUrl)

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
    productsStore.setProductListItems(productListItemsData)
    productsStore.setLinks(productListItemsLinks)
    productsStore.setMeta(productListItemsMeta)
    productsStore.setProduct(product)
    productsStore.setOriginProduct(originProduct)

    const availabilityStatusesStore = useAvailabilityStatusesStore(pinia)
    availabilityStatusesStore.setEntities(availabilityStatusesData)

    const billStatusesStore = useBillStatusesStore(pinia)
    billStatusesStore.setEntities(billStatusesData)

    const currenciesStore = useCurrenciesStore(pinia)
    currenciesStore.setEntities(currenciesData)
    currenciesStore.setRates(currencyTodayRate)

    const paymentMethodsStore = usePaymentMethodsStore(pinia)
    paymentMethodsStore.setEntities(paymentMethodsData)

    const orderImportanceStore = useOrderImportanceStore(pinia)
    orderImportanceStore.setEntities(orderImportanceData)

    const orderStatusesStore = useOrderStatusesStore(pinia)
    orderStatusesStore.setEntities(orderStatusesData)

    const charsStore = useCharTypesStore(pinia)
    charsStore.setChartTypes(charTypesData)
}
