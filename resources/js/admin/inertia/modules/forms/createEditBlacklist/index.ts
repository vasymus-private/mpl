import { defineStore } from "pinia"
import {
    AdminTab,
    ErrorResponse,
    TabEnum,
} from "@/admin/inertia/modules/common/types"
import ElementsTab from "@/admin/inertia/components/blacklist/createEdit/tabs/ElementsTab.vue"
import { Values } from "@/admin/inertia/modules/forms/createEditBlacklist/types"
import { SubmissionContext } from "vee-validate"
import { routeNames, useRoutesStore } from "@/admin/inertia/modules/routes"
import axios, { AxiosError } from "axios"
import { Inertia } from "@inertiajs/inertia"
import { errorsToErrorFields } from "@/admin/inertia/modules/common"
import * as yup from "yup"
import { yupIntegerOrEmptyString } from "@/admin/inertia/utils"
import { useBlacklistStore } from "@/admin/inertia/modules/blacklist"
import { Blacklist } from "@/admin/inertia/modules/blacklist/types"

export const storeName = "createEditBlacklistForm"

export const useCreateEditBlacklistFormStore = defineStore(storeName, {
    getters: {
        blacklistFormTitle: (): string => {
            let base = "Справочники: чёрный список: "
            const blacklistStore = useBlacklistStore()

            base += blacklistStore.isCreatingBlacklistRoute
                ? "добавление"
                : `${blacklistStore.blacklist?.id} - редактирование`

            return base
        },
        allAdminTabs: (): Array<AdminTab> => {
            return [
                {
                    value: TabEnum.elements,
                    label: "Элемент",
                    is: ElementsTab,
                },
            ]
        },
    },
    actions: {
        async submitCreateEditBlacklist(
            values: Values,
            ctx: SubmissionContext<Values>
        ): Promise<void> {
            const blacklistStore = useBlacklistStore()
            const routesStore = useRoutesStore()

            try {
                let blacklist: Blacklist

                const formData = valuesToFormData(values)

                if (blacklistStore.isCreatingBlacklistRoute) {
                    const response = await axios.post<{ data: Blacklist }>(
                        routesStore.route(
                            routeNames.ROUTE_ADMIN_AJAX_BLACKLIST_STORE
                        ),
                        formData,
                        {
                            headers: { "Content-Type": "multipart/form-data" },
                        }
                    )
                    blacklist = response.data.data
                    Inertia.get(
                        routesStore.route(
                            routeNames.ROUTE_ADMIN_BLACKLIST_EDIT,
                            {
                                admin_blacklist: blacklist.id,
                            }
                        )
                    )
                } else {
                    formData.append("_method", "PUT")

                    const response = await axios.post<{ data: Blacklist }>(
                        routesStore.route(
                            routeNames.ROUTE_ADMIN_AJAX_BLACKLIST_UPDATE,
                            values.id
                        ),
                        formData,
                        {
                            headers: { "Content-Type": "multipart/form-data" },
                        }
                    )
                    blacklist = response.data.data
                    blacklistStore.setEntity(blacklist)
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
        ip: yup.string().max(250),
        email: yup.string().max(250),
    })
}

export const getWatchBlacklistToFormCb =
    (setValues: (a: object) => any) => (blacklist: Blacklist | null) => {
        const { id, uuid, ip, email } = blacklist || {}

        const values = {
            id,
            uuid,
            ip,
            email,
        }

        setValues(values)
    }

const valuesToFormData = (values: Values): FormData => {
    let cfd = require("@/admin/inertia/utils/CustomFormData")
    const formData = new cfd.CustomFormData()

    let stringOrNumberKeys: Array<keyof Values> = ["ip", "email"]

    stringOrNumberKeys.forEach((key) => {
        let value = values[key] as string | number | null | undefined
        formData.setStringOrNumber(key, value)
    })

    return formData
}
