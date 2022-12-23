import {defineStore} from "pinia"
import {FaqsResponse, Values} from "@/admin/inertia/modules/forms/indexFaqs/types"
import {routeNames, useRoutesStore} from "@/admin/inertia/modules/routes"
import axios, {AxiosError} from "axios"
import {arrayToMap} from "@/admin/inertia/utils"
import {FaqListItem} from "@/admin/inertia/modules/faqs/types"
import useFormHelpers from "@/admin/inertia/composables/useFormHelpers"
import {ErrorResponse} from "@/admin/inertia/modules/common/types"
import * as yup from "yup"
import {useFaqsStore} from "@/admin/inertia/modules/faqs"

export const storeName = "indexFaqsForm"

export const useIndexFaqsFormStore = defineStore(storeName, {
    actions: {
        async submitIndexFaqs(
            checkedFaqs: Array<string>,
            values: Values
        ): Promise<void | Record<string, string | undefined>> {
            try {
                let faqsToUpdate = values.faqs.filter((item) =>
                    checkedFaqs.includes(item.uuid)
                )
                if (!faqsToUpdate.length) {
                    return
                }
                const routesStore = useRoutesStore()
                const {
                    data: { data: faqsResponse = [] },
                } = await axios.put<FaqsResponse>(
                    routesStore.route(
                        routeNames.ROUTE_ADMIN_AJAX_FAQ_BULK_UPDATE
                    ),
                    {
                        faqs: arrayToMap<Partial<FaqListItem>>(
                            faqsToUpdate
                        ),
                    }
                )

                const faqStore = useFaqsStore()
                faqStore.addOrUpdateFaqsListItems(faqsResponse)
            } catch (e) {
                if (e instanceof AxiosError) {
                    const { errorsToErrorFields } = useFormHelpers<Values>(
                        "faqs",
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
        faqs: yup.array().of(
            yup.object({
                id: yup.number().required(),
                uuid: yup.string().max(36).required(),
                name: yup.string().required().max(250),
                is_active: yup.boolean(),
            })
        ),
    })
