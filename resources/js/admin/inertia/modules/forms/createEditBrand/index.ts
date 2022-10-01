import { defineStore } from "pinia"
import { useBrandsStore } from "@/admin/inertia/modules/brands"
import { AdminTab, TabEnum } from "@/admin/inertia/modules/common/Tabs"
import ElementsTab from "@/admin/inertia/components/brands/createEdit/tabs/ElementsTab.vue"
import DescriptionTab from "@/admin/inertia/components/brands/createEdit/tabs/DescriptionTab.vue"
import PhotoTab from "@/admin/inertia/components/brands/createEdit/tabs/PhotoTab.vue"
import SeoTab from "@/admin/inertia/components/brands/createEdit/tabs/SeoTab.vue"
import { SubmissionContext } from "vee-validate"
import { Values } from "@/admin/inertia/modules/forms/createEditBrand/types"
import * as yup from "yup"
import { yupIntegerOrEmptyString } from "@/admin/inertia/utils"
import { Brand } from "@/admin/inertia/modules/brands/types"
import { CustomFormData } from "@/admin/inertia/utils/CustomFormData"
import axios, { AxiosError } from "axios"
import { routeNames, useRoutesStore } from "@/admin/inertia/modules/routes"
import { Inertia } from "@inertiajs/inertia"
import { ErrorResponse } from "@/admin/inertia/modules/common/types"
import { errorsToErrorFields, getMediaSchema } from "@/admin/inertia/modules/common"

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
            const brandsStore = useBrandsStore()
            const routesStore = useRoutesStore()

            try {
                let brand: Brand

                const formData = valuesToFormData(values)

                if (brandsStore.isCreatingBrandRoute) {
                    const response = await axios.post<{ data: Brand }>(
                        routesStore.route(
                            routeNames.ROUTE_ADMIN_AJAX_BRANDS_STORE
                        ),
                        formData,
                        {
                            headers: { "Content-Type": "multipart/form-data" },
                        }
                    )
                    brand = response.data.data
                    Inertia.get(
                        routesStore.route(
                            routeNames.ROUTE_ADMIN_BRANDS_TEMP_EDIT,
                            {
                                admin_brand: brand.id,
                            }
                        )
                    )
                } else {
                    formData.append("_method", "PUT")

                    const response = await axios.post<{ data: Brand }>(
                        routesStore.route(
                            routeNames.ROUTE_ADMIN_AJAX_BRANDS_UPDATE,
                            values.id
                        ),
                        formData,
                        {
                            headers: { "Content-Type": "multipart/form-data" },
                        }
                    )
                    brand = response.data.data
                    brandsStore.setEntity(brand)
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
        mainImage: getMediaSchema().nullable(),
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

const valuesToFormData = (values: Values): FormData => {
    const formData = new CustomFormData()

    let stringOrNumberKeys: Array<keyof Values> = [
        "name",
        "slug",
        "ordering",
        "preview",
        "description",
    ]

    stringOrNumberKeys.forEach((key) => {
        let value = values[key] as string | number | null | undefined
        formData.setStringOrNumber(key, value)
    })

    if (values.seo) {
        formData.appendStringOrNumber("seo[title]", values.seo.title)
        formData.appendStringOrNumber("seo[h1]", values.seo.h1)
        formData.appendStringOrNumber("seo[keywords]", values.seo.keywords)
        formData.appendStringOrNumber(
            "seo[description]",
            values.seo.description
        )
    }

    if (values.mainImage) {
        formData.appendStringOrNumber(`mainImage[id]`, values.mainImage.id)
        formData.appendStringOrNumber(`mainImage[uuid]`, values.mainImage.uuid)
        formData.appendStringOrNumber(`mainImage[name]`, values.mainImage.name)
        formData.appendStringOrNumber(
            `mainImage[file_name]`,
            values.mainImage.file_name
        )
        formData.appendStringOrNumber(
            `mainImage[order_column]`,
            values.mainImage.order_column
        )

        formData.appendFile(`mainImage[file]`, values.mainImage.file)
    }

    return formData
}
