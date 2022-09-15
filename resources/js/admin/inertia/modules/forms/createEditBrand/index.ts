import { defineStore } from "pinia"
import { useBrandsStore } from "@/admin/inertia/modules/brands"
import { AdminTab, TabEnum } from "@/admin/inertia/modules/common/Tabs"
import ElementsTab from "@/admin/inertia/components/brands/createEdit/tabs/ElementsTab.vue"
import DescriptionTab from "@/admin/inertia/components/brands/createEdit/tabs/DescriptionTab.vue"
import PhotoTab from "@/admin/inertia/components/brands/createEdit/tabs/PhotoTab.vue"
import SeoTab from "@/admin/inertia/components/brands/createEdit/tabs/SeoTab.vue"
import {SubmissionContext} from "vee-validate"
import {Values} from "@/admin/inertia/modules/forms/createEditBrand/types"
import * as yup from "yup"
import {yupIntegerOrEmptyString} from "@/admin/inertia/utils"
import {Brand} from "@/admin/inertia/modules/brands/types"
import {getImageSchema} from "@/admin/inertia/modules/forms/createEditProduct";

export const storeName = "createEditBrandForm"

export const useCreateEditBrandFormStore = defineStore(storeName, {
    getters: {
        brandFormTitle: (): string => {
            let base = "Справочники: производители: "
            const brandsStore = useBrandsStore()

            base += brandsStore.isCreatingBrandRoute
                ? "добавление"
                : `${brandsStore.brand?.name} - редактирование`

            return base
        },
        allAdminTabs: (): Array<AdminTab> => {
            return [
                {
                    value: TabEnum.elements,
                    label: "Элемент",
                    is: ElementsTab,
                },
                {
                    value: TabEnum.description,
                    label: "Описание",
                    is: DescriptionTab,
                },
                {
                    value: TabEnum.photo,
                    label: "Фото",
                    is: PhotoTab,
                },
                {
                    value: TabEnum.seo,
                    label: "SEO",
                    is: SeoTab,
                },
            ]
        },
    },
    actions: {
        async submitCreateEditBrands(
            values: Values,
            ctx: SubmissionContext<Values>
        ): Promise<void> {

        }
    }
})

export const getFormSchema = () => {
    return yup.object({
        id: yupIntegerOrEmptyString(),
        name: yup.string().required().max(250),
        slug: yup.string().required().max(250),
        ordering: yupIntegerOrEmptyString(),
        preview: yup.string().max(65000).nullable(),
        description: yup.string().max(65000).nullable(),
        seo: yup
            .object({
                title: yup.string().max(250).nullable(),
                h1: yup.string().max(250).nullable(),
                keywords: yup.string().max(65000).nullable(),
                description: yup.string().max(65000).nullable(),
            })
            .nullable(),
        mainImage: getImageSchema().nullable(),
    })
}

export const getWatchBrandToFormCb =
    (setValues: (a: object) => any) => (brand: Brand | null) => {
        const {
            id,
            name,
            slug,
            ordering,
            preview,
            description,
            seo,
            mainImage,
        } = brand || {}

        const values = {
            id,
            name,
            slug,
            ordering,
            preview,
            description,
            seo,
            mainImage,
        }

        setValues(values)
    }
