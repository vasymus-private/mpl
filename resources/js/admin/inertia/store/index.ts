import Column from "@/admin/inertia/entities/Column"
import Article from "@/admin/inertia/entities/Article"
import Auth from "@/admin/inertia/entities/Auth"
import Option from "@/admin/inertia/entities/Option"
import CategoryTreeItem from "@/admin/inertia/entities/CategoryTreeItem"
import { useAuthStore } from "@/admin/inertia/store/auth"
import { Pinia } from "pinia"
import { useArticlesStore } from "@/admin/inertia/store/articles"
import { Service } from "@/admin/inertia/entities/Service"
import { useServicesStore } from "@/admin/inertia/store/services"

// props on all page @see \App\Http\Middleware\HandleInertiaRequests::share()
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
    }: {
        adminOrderColumns: Array<Column>
        adminProductColumns: Array<Column>
        adminProductVariantColumns: Array<Column>
        articles: Array<Article>
        auth: Auth
        brandOptions: Array<Option>
        categoriesTree: Array<CategoryTreeItem>
        services: Array<Service>
    } = initialPageProps

    const authStore = useAuthStore(pinia)
    authStore.setAuthUser(auth.user)

    const articlesStore = useArticlesStore(pinia)
    articlesStore.setEntities(articles)

    const servicesStore = useServicesStore(pinia)
    servicesStore.setEntities(services)
}
