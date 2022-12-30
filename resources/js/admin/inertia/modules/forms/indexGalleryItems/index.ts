import { defineStore } from "pinia"
import {
    GalleryItemsResponse,
    Values,
} from "@/admin/inertia/modules/forms/indexGalleryItems/types"
import { routeNames, useRoutesStore } from "@/admin/inertia/modules/routes"
import axios, { AxiosError } from "axios"
import { arrayToMap } from "@/admin/inertia/utils"
import { GalleryItemListItem } from "@/admin/inertia/modules/galleryItems/types"
import useFormHelpers from "@/admin/inertia/composables/useFormHelpers"
import { ErrorResponse } from "@/admin/inertia/modules/common/types"
import * as yup from "yup"
import {useGalleryItemsStore} from "@/admin/inertia/modules/galleryItems"

export const storeName = "indexGalleryItemsForm"

export const useIndexGalleryItemsFormStore = defineStore(storeName, {
    actions: {
        async submitIndexGalleryItems(
            checkedGalleryItems: Array<string>,
            values: Values
        ): Promise<void | Record<string, string | undefined>> {
            try {
                let galleryItemsToUpdate = values.galleryItems.filter((item) =>
                    checkedGalleryItems.includes(item.uuid)
                )
                if (!galleryItemsToUpdate.length) {
                    return
                }
                const routesStore = useRoutesStore()
                const {
                    data: { data: galleryItemsResponse = [] },
                } = await axios.put<GalleryItemsResponse>(
                    routesStore.route(
                        routeNames.ROUTE_ADMIN_AJAX_GALLERY_ITEMS_BULK_UPDATE
                    ),
                    {
                        galleryItems:
                            arrayToMap<Partial<GalleryItemListItem>>(
                                galleryItemsToUpdate
                            ),
                    }
                )

                const galleryItemsStore = useGalleryItemsStore()
                galleryItemsStore.addOrUpdateGalleryItemListItems(galleryItemsResponse)
            } catch (e) {
                if (e instanceof AxiosError) {
                    const { errorsToErrorFields } = useFormHelpers<Values>(
                        "galleryItems",
                        values
                    )

                    const {
                        data: { errors },
                    }: ErrorResponse = e.response

                    return errorsToErrorFields(errors)
                }
                throw e
            }
        },
    },
})

export const getValidationSchema = () =>
    yup.object({
        galleryItems: yup.array().of(
            yup.object({
                id: yup.number().required(),
                uuid: yup.string().max(36).required(),
                name: yup.string().required().max(250),
                is_active: yup.boolean(),
            })
        ),
    })
