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
}
