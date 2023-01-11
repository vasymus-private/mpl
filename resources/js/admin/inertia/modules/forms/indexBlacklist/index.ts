import { defineStore } from "pinia"
import {
    BlacklistItemsResponse,
    Values,
} from "@/admin/inertia/modules/forms/indexBlacklist/types"
import { routeNames, useRoutesStore } from "@/admin/inertia/modules/routes"
import axios, { AxiosError } from "axios"
import { arrayToMap } from "@/admin/inertia/utils"
import useFormHelpers from "@/admin/inertia/composables/useFormHelpers"
import { ErrorResponse } from "@/admin/inertia/modules/common/types"
import * as yup from "yup"
import { useBlacklistStore } from "@/admin/inertia/modules/blacklist"
import { BlacklistItem } from "@/admin/inertia/modules/blacklist/types"

export const storeName = "indexBlacklistForm"

export const useIndexBlacklistFormStore = defineStore(storeName, {
    actions: {
        async submitIndexBlacklist(
            checkedBlacklist: Array<string>,
            values: Values
        ): Promise<void | Record<string, string | undefined>> {
            try {
                let blacklistItemsToUpdate = values.blacklistItems.filter(
                    (item) => checkedBlacklist.includes(item.uuid)
                )
                if (!blacklistItemsToUpdate.length) {
                    return
                }
                const routesStore = useRoutesStore()
                const {
                    data: { data: blacklistItemsResponse = [] },
                } = await axios.put<BlacklistItemsResponse>(
                    routesStore.route(
                        routeNames.ROUTE_ADMIN_AJAX_BLACKLIST_BULK_UPDATE
                    ),
                    {
                        blacklistItems: arrayToMap<Partial<BlacklistItem>>(
                            blacklistItemsToUpdate
                        ),
                    }
                )

                const blacklistStore = useBlacklistStore()
                blacklistStore.addOrUpdateBlacklistItems(blacklistItemsResponse)
            } catch (e) {
                if (e instanceof AxiosError) {
                    const { errorsToErrorFields } = useFormHelpers<Values>(
                        "blacklistItems",
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
        blacklistItems: yup.array().of(
            yup.object({
                id: yup.number().required(),
                uuid: yup.string().max(36).required(),
                name: yup.string().max(250),
                email: yup.string().max(250),
            })
        ),
    })
