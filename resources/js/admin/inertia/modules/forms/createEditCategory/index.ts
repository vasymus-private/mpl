import { defineStore } from "pinia"
import { useCategoriesStore } from "@/admin/inertia/modules/categories"
import Option from "@/admin/inertia/modules/common/Option"
import {AdminTab, TabEnum} from "@/admin/inertia/modules/common/Tabs"
import ElementsTab from "@/admin/inertia/components/categories/createEdit/tabs/ElementsTab.vue"
import SeoTab from "@/admin/inertia/components/categories/createEdit/tabs/SeoTab.vue"
import ProductsTab from "@/admin/inertia/components/categories/createEdit/tabs/ProductsTab.vue"
import * as yup from "yup"
import {yupIntegerOrEmptyString} from "@/admin/inertia/utils"
import {Values} from "@/admin/inertia/modules/forms/createEditCategory/types"
import {SubmissionContext} from "vee-validate"
import {Category} from "@/admin/inertia/modules/categories/types"


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

            const categoryAndSubtreeIds = categoriesStore.getCategoryAndSubtreeIds(categoryId)
            if (!categoryAndSubtreeIds) {
                return categoriesStore.options
            }

            return categoriesStore.options.map(option => {
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
        async submitCreateEditCategory(values: Values, ctx: SubmissionContext<Values>): Promise<void> {

        }
    }
})

export const getFormSchema = () => {
    return yup.object({
        id: yupIntegerOrEmptyString(),
        name: yup.string().required().max(250),
        slug: yup.string().required().max(250),
        ordering: yupIntegerOrEmptyString(),
        is_active: yup.boolean(),
        description: yup.string().max(65000).nullable(),
        parent_id: yupIntegerOrEmptyString(),
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
            ordering,
            description,
            seo,
        }

        console.log("--- values", values)
        setValues(values)
    }
