import { Column } from "@/admin/inertia/modules/columns/types"
import {
    Article,
    ArticleListItem,
} from "@/admin/inertia/modules/articles/types"
import { Auth } from "@/admin/inertia/modules/auth/types"
import {
    CategoriesTreeItem,
    Category,
    CategoryListItem,
} from "@/admin/inertia/modules/categories/types"
import { useAuthStore } from "@/admin/inertia/modules/auth"
import { Pinia } from "pinia"
import { useArticlesStore } from "@/admin/inertia/modules/articles"
import { useCategoriesStore } from "@/admin/inertia/modules/categories"
import { useColumnsStore } from "@/admin/inertia/modules/columns"
import { useBrandsStore } from "@/admin/inertia/modules/brands"
import {
    ProductListItem,
    Product,
} from "@/admin/inertia/modules/products/types"
import { useProductsStore } from "@/admin/inertia/modules/products"
import { AvailabilityStatus } from "@/admin/inertia/modules/availabilityStatuses/types"
import { useAvailabilityStatusesStore } from "@/admin/inertia/modules/availabilityStatuses"
import { BillStatus } from "@/admin/inertia/modules/billStatuses/types"
import { useBillStatusesStore } from "@/admin/inertia/modules/billStatuses"
import { Currency, Rate } from "@/admin/inertia/modules/currencies/types"
import { useCurrenciesStore } from "@/admin/inertia/modules/currencies"
import { PaymentMethod } from "@/admin/inertia/modules/paymentMethods/types"
import { usePaymentMethodsStore } from "@/admin/inertia/modules/paymentMethods"
import { OrderImportance } from "@/admin/inertia/modules/orderImportance/types"
import { useOrderImportanceStore } from "@/admin/inertia/modules/orderImportance"
import { OrderStatus } from "@/admin/inertia/modules/orderStatuses/types"
import { useOrderStatusesStore } from "@/admin/inertia/modules/orderStatuses"
import { CharType } from "@/admin/inertia/modules/charTypes/types"
import { useCharTypesStore } from "@/admin/inertia/modules/charTypes"
import { Links, Meta, Option } from "@/admin/inertia/modules/common/types"
import { useRoutesStore } from "@/admin/inertia/modules/routes"
import { useProfileStore } from "@/admin/inertia/modules/profile"
import { Brand, BrandListItem } from "@/admin/inertia/modules/brands/types"
import {
    Order,
    OrderEvent,
    OrderItem,
} from "@/admin/inertia/modules/orders/types"
import { useOrdersStore } from "@/admin/inertia/modules/orders"
import { Admin } from "@/admin/inertia/modules/auth/types"
import { useFaqsStore } from "@/admin/inertia/modules/faqs"
import { Faq, FaqListItem } from "@/admin/inertia/modules/faqs/types"

export interface InitialPageProps {
    fullUrl: string
    auth: Auth
    categoriesTree: Array<CategoriesTreeItem>
    brandOptions: Array<Option>
    adminOrderColumns: Array<Column>
    adminProductColumns: Array<Column>
    adminProductVariantColumns: Array<Column>
    adminSidebarFlexBasis: string | number | null
    availabilityStatuses: { data: Array<AvailabilityStatus> }
    billStatuses: { data: Array<BillStatus> }
    currencies: { data: Array<Currency> }
    currencyTodayRate: Array<Rate>
    paymentMethods: { data: Array<PaymentMethod> }
    orderImportance: { data: Array<OrderImportance> }
    orderStatuses: { data: Array<OrderStatus> }
    charTypes: { data: Array<CharType> }
    faqOptions: Array<Option>
    articleOptions: Array<Option>

    articleListItems?: {
        data: Array<ArticleListItem>
        links: Links
        meta: Meta
    }
    article?: Article
    productListItems?: {
        data: Array<ProductListItem>
        links: Links
        meta: Meta
    }
    product?: Product
    categories?: {
        data: Array<CategoryListItem>
    }
    category?: Category
    brands?: {
        data: Array<BrandListItem>
        links: Links
        meta: Meta
    }
    brand?: Brand | null
    orders?: {
        data: Array<OrderItem>
        links: Links
        meta: Meta
    }
    order?: Order | null
    orderEvents?: {
        data: Array<OrderEvent>
    }
    admins?: Array<Admin>
    faqs?: {
        data: Array<FaqListItem>
        links: Links
        meta: Meta
    }
    faq?: Faq | null
}

/**
 * props on all page + props specific for concrete controller
 * @see \App\Http\Middleware\HandleInertiaRequests::share()
 */
export const initFromPageProps = (
    pinia: Pinia,
    initialPageProps: InitialPageProps
) => {
    let {
        fullUrl,
        auth,
        categoriesTree = [],
        brandOptions = [],
        adminOrderColumns = [],
        adminProductColumns = [],
        adminProductVariantColumns = [],
        adminSidebarFlexBasis = null,
        availabilityStatuses: { data: availabilityStatusesData = [] },
        billStatuses: { data: billStatusesData = [] },
        currencies: { data: currenciesData = [] },
        currencyTodayRate = [],
        paymentMethods: { data: paymentMethodsData = [] },
        orderImportance: { data: orderImportanceData = [] },
        orderStatuses: { data: orderStatusesData = [] },
        charTypes: { data: charTypesData = [] },
        faqOptions = [],
        articleOptions = [],

        articleListItems: {
            data: articleListItemsData = [],
            links: articleListItemsLinks = null,
            meta: articleListItemsMeta = null,
        },
        article = null,
        productListItems: {
            data: productListItemsData = [],
            links: productListItemsLinks = null,
            meta: productListItemsMeta = null,
        } = {},
        product = null,
        categories: { data: categoryListItems = [] } = {},
        category = null,
        brands: {
            data: brandsList = [],
            links: brandsListLinks = null,
            meta: brandsListMeta = null,
        } = {},
        brand = null,
        orders: {
            data: ordersList = [],
            links: ordersListLinks = null,
            meta: ordersListMeta = null,
        } = {},
        order = null,
        orderEvents: { data: orderEventsData = [] } = {},
        admins = [],
        faqs: {
            data: faqsList = [],
            links: faqsListLinks = null,
            meta: faqsListMeta = null,
        } = {},
        faq = null,
    } = initialPageProps

    // todo dev only
    if (typeof window !== "undefined") {
        // @ts-ignore
        window.__initialPageProps = initialPageProps
    }

    const routesStore = useRoutesStore(pinia)
    routesStore.setFullUrl(fullUrl)

    const authStore = useAuthStore(pinia)
    authStore.setAuthUser(auth.user)
    authStore.setAdmins(admins)

    const articlesStore = useArticlesStore(pinia)
    articlesStore.setEntities(articleListItemsData)
    articlesStore.setLinks(articleListItemsLinks)
    articlesStore.setMeta(articleListItemsMeta)
    articlesStore.setEntity(article)
    articlesStore.setOptions(articleOptions)

    const categoriesStore = useCategoriesStore(pinia)
    categoriesStore.setEntities(categoriesTree)
    categoriesStore.setEntity(category)
    categoriesStore.setListItems(categoryListItems)

    const columnsStore = useColumnsStore(pinia)
    columnsStore.setAdminOrderColumns(adminOrderColumns)
    columnsStore.setAdminProductColumns(adminProductColumns)
    columnsStore.setAdminProductVariantColumns(adminProductVariantColumns)

    const brandsStore = useBrandsStore(pinia)
    brandsStore.setEntities(brandsList)
    brandsStore.setLinks(brandsListLinks)
    brandsStore.setMeta(brandsListMeta)
    brandsStore.setEntity(brand)
    brandsStore.setOptions(brandOptions)

    const productsStore = useProductsStore(pinia)
    productsStore.setProductListItems(productListItemsData)
    productsStore.setLinks(productListItemsLinks)
    productsStore.setMeta(productListItemsMeta)
    productsStore.setProduct(product)

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

    const faqsStore = useFaqsStore(pinia)
    faqsStore.setEntities(faqsList)
    faqsStore.setMeta(faqsListMeta)
    faqsStore.setLinks(faqsListLinks)
    faqsStore.setEntity(faq)
    faqsStore.setOptions(faqOptions)

    const profileStore = useProfileStore(pinia)
    profileStore.setAdminSidebarFlexBasis(adminSidebarFlexBasis)

    const ordersStore = useOrdersStore(pinia)
    ordersStore.setOrdersList(ordersList)
    ordersStore.setLinks(ordersListLinks)
    ordersStore.setMeta(ordersListMeta)
    ordersStore.setOrder(order)
    ordersStore.setOrderEvents(orderEventsData)

    // todo dev only
    if (typeof window !== "undefined") {
        // @ts-ignore
        window.__pinia = pinia
    }
}
