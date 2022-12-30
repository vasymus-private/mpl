import { defineStore } from "pinia"
import {
    AdminTab,
    ErrorResponse,
    TabEnum,
} from "@/admin/inertia/modules/common/types"
import ElementsTab from "@/admin/inertia/components/galleryItems/createEdit/tabs/ElementsTab.vue"
import DescriptionTab from "@/admin/inertia/components/galleryItems/createEdit/tabs/DescriptionTab.vue"
import SeoTab from "@/admin/inertia/components/galleryItems/createEdit/tabs/SeoTab.vue"
import PhotoTab from "@/admin/inertia/components/galleryItems/createEdit/tabs/PhotoTab.vue"
import { Values } from "@/admin/inertia/modules/forms/createEditGalleryItem/types"
import { SubmissionContext } from "vee-validate"
import { routeNames, useRoutesStore } from "@/admin/inertia/modules/routes"
import axios, { AxiosError } from "axios"
import { Inertia } from "@inertiajs/inertia"
import {
    errorsToErrorFields,
    getMediaSchema,
} from "@/admin/inertia/modules/common"
import * as yup from "yup"
import { yupIntegerOrEmptyString } from "@/admin/inertia/utils"
import { GalleryItem } from "@/admin/inertia/modules/galleryItems/types"
import { useGalleryItemsStore } from "@/admin/inertia/modules/galleryItems"

export const storeName = "createEditGalleryItemForm"

export const useCreateEditGalleryItemFormStore = defineStore(storeName, {
    getters: {
        galleryItemFormTitle: (): string => {
            let base = "Справочники: галерея: "
            const galleryItemsStore = useGalleryItemsStore()

            base += galleryItemsStore.isCreatingGalleryItemRoute
                ? "добавление"
                : `${galleryItemsStore.galleryItem?.name} - редактирование`

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
                    value: TabEnum.photo,
                    label: "Фото",
                    is: PhotoTab,
                },
                {
                    value: TabEnum.description,
                    label: "Описание",
                    is: DescriptionTab,
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
        async submitCreateEditGalleryItem(
            values: Values,
            ctx: SubmissionContext<Values>
        ): Promise<void> {
            const galleryItemsStore = useGalleryItemsStore()
            const routesStore = useRoutesStore()

            try {
                let galleryItem: GalleryItem

                const formData = valuesToFormData(values)

                if (galleryItemsStore.isCreatingGalleryItemRoute) {
                    const response = await axios.post<{ data: GalleryItem }>(
                        routesStore.route(
                            routeNames.ROUTE_ADMIN_AJAX_GALLERY_ITEM_STORE
                        ),
                        formData,
                        {
                            headers: { "Content-Type": "multipart/form-data" },
                        }
                    )
                    galleryItem = response.data.data
                    Inertia.get(
                        routesStore.route(
                            routeNames.ROUTE_ADMIN_GALLERY_ITEMS_EDIT,
                            {
                                admin_gallery_item: galleryItem.id,
                            }
                        )
                    )
                } else {
                    formData.append("_method", "PUT")

                    const response = await axios.post<{ data: GalleryItem }>(
                        routesStore.route(
                            routeNames.ROUTE_ADMIN_AJAX_GALLERY_ITEM_UPDATE,
                            values.id
                        ),
                        formData,
                        {
                            headers: { "Content-Type": "multipart/form-data" },
                        }
                    )
                    galleryItem = response.data.data
                    galleryItemsStore.setEntity(galleryItem)
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
        uuid: yup.string().nullable(),
        name: yup.string().required().max(250),
        slug: yup.string().required().max(250),
        is_active: yup.boolean(),
        parent_id: yupIntegerOrEmptyString(),
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

export const getWatchGalleryItemToFormCb =
    (setValues: (a: object) => any) => (galleryItem: GalleryItem | null) => {
        const {
            id,
            name,
            slug,
            is_active,
            parent_id,
            description,
            seo,
            mainImage,
        } = galleryItem || {}

        const values = {
            id,
            name,
            slug,
            is_active,
            parent_id,
            description,
            seo,
            mainImage,
        }

        setValues(values)
    }

const valuesToFormData = (values: Values): FormData => {
    let cfd = require("@/admin/inertia/utils/CustomFormData")
    const formData = new cfd.CustomFormData()

    let stringOrNumberKeys: Array<keyof Values> = [
        "name",
        "slug",
        "parent_id",
        "description",
    ]

    stringOrNumberKeys.forEach((key) => {
        let value = values[key] as string | number | null | undefined
        formData.setStringOrNumber(key, value)
    })

    let booleanKeys: Array<keyof Values> = ["is_active"]

    booleanKeys.forEach((key) => {
        let value = values[key] as boolean | null | undefined
        formData.setBoolean(key, value)
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
