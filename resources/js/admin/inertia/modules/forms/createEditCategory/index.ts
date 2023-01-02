import { defineStore } from "pinia"
import { useCategoriesStore } from "@/admin/inertia/modules/categories"
import ElementsTab from "@/admin/inertia/components/categories/createEdit/tabs/ElementsTab.vue"
import SeoTab from "@/admin/inertia/components/categories/createEdit/tabs/SeoTab.vue"
import ProductsTab from "@/admin/inertia/components/categories/createEdit/tabs/ProductsTab.vue"
import * as yup from "yup"
import { yupIntegerOrEmptyString } from "@/admin/inertia/utils"
import { Values } from "@/admin/inertia/modules/forms/createEditCategory/types"
import { SubmissionContext } from "vee-validate"
import { Category } from "@/admin/inertia/modules/categories/types"
import axios, { AxiosError } from "axios"
import { routeNames, useRoutesStore } from "@/admin/inertia/modules/routes"
import { Inertia } from "@inertiajs/inertia"
import {
    ErrorResponse,
    AdminTab,
    TabEnum,
    Option,
} from "@/admin/inertia/modules/common/types"
import { errorsToErrorFields } from "@/admin/inertia/modules/common"

export const storeName = "createEditCategoryForm"

export const useCreateEditCategoryFormStore = defineStore(storeName, {
    getters: {
        categoryFormTitle: (): string => {
            let base = "Товары: раздел: "
            const categoriesStore = useCategoriesStore()

            base += categoriesStore.isCreatingCategoryRoute
                ? "добавление"
                : `${categoriesStore.category?.name} - редактирование`

            return base
        },
        parentCategoryOptions(): Array<Option> {
            const categoriesStore = useCategoriesStore()
            const categoryId = categoriesStore.category?.id

            const categoryAndSubtreeIds =
                categoriesStore.getCategoryAndSubtreeIds(categoryId)
            if (!categoryAndSubtreeIds) {
                return categoriesStore.options
            }

            return categoriesStore.options.map((option) => {
                if (categoryAndSubtreeIds.includes(+option.value)) {
                    option.disabled = true
                }

                return option
            })
        },
        allAdminTabs: (): Array<AdminTab> => {
            return [
                {
                    value: TabEnum.elements,
                    label: "Элемент",
                    is: ElementsTab,
                },
                {
                    value: TabEnum.seo,
                    label: "SEO",
                    is: SeoTab,
                },
                {
                    value: TabEnum.products,
                    label: "Товары",
                    is: ProductsTab,
                },
            ]
        },
    },
    actions: {
        async submitCreateEditCategory(
            values: Values,
            ctx: SubmissionContext<Values>
        ): Promise<void> {
            const categoriesStore = useCategoriesStore()
            const routesStore = useRoutesStore()

            try {
                let category: Category

                if (categoriesStore.isCreatingCategoryRoute) {
                    const response = await axios.post<{ data: Category }>(
                        routesStore.route(
                            routeNames.ROUTE_ADMIN_AJAX_CATEGORIES_STORE
                        ),
                        values
                    )

                    category = response.data.data
                    Inertia.get(
                        routesStore.route(
                            routeNames.ROUTE_ADMIN_CATEGORIES_TEMP_EDIT,
                            {
                                admin_category: category.id,
                            }
                        )
                    )
                } else {
                    const response = await axios.put<{ data: Category }>(
                        routesStore.route(
                            routeNames.ROUTE_ADMIN_AJAX_CATEGORIES_UPDATE,
                            values.id
                        ),
                        values
                    )

                    category = response.data.data
                    categoriesStore.setEntity(category)
                }
            } catch (e) {
                if (e instanceof AxiosError) {
                    const {
                        data: { errors },
                    }: ErrorResponse = e.response

                    const errorFields = errorsToErrorFields(errors)

                    ctx.setErrors(errorFields)
                    return
                }

                throw e
            }
        },
    },
})

export const getFormSchema = () => {
    return yup.object({
        id: yupIntegerOrEmptyString(),
        name: yup.string().required().max(250),
        slug: yup.string().nullable().max(250),
        ordering: yupIntegerOrEmptyString(),
        is_active: yup.boolean(),
        description: yup.string().max(65000).nullable(),
        parent_id: yupIntegerOrEmptyString(),
        product_type: yupIntegerOrEmptyString(),
        seo: yup
            .object({
                title: yup.string().max(250).nullable(),
                h1: yup.string().max(250).nullable(),
                keywords: yup.string().max(65000).nullable(),
                description: yup.string().max(65000).nullable(),
            })
            .nullable(),
    })
}

export const getWatchPCategoryToFormCb =
    (setValues: (a: object) => any) => (category: Category | null) => {
        const {
            id,
            name,
            slug,
            is_active,
            parent_id,
            product_type,
            ordering,
            description,
            seo,
        } = category || {}

        const values = {
            id,
            name,
            slug,
            is_active,
            parent_id,
            product_type,
            ordering,
            description,
            seo,
        }

        setValues(values)
    }
