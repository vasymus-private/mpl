import {defineStore} from "pinia"
import {useFaqsStore} from "@/admin/inertia/modules/faqs"
import {AdminTab, ErrorResponse, TabEnum} from "@/admin/inertia/modules/common/types"
import ElementsTab from "@/admin/inertia/components/faqs/createEdit/tabs/ElementsTab.vue"
import {Values} from "@/admin/inertia/modules/forms/createEditFaq/types"
import {SubmissionContext} from "vee-validate"
import {routeNames, useRoutesStore} from "@/admin/inertia/modules/routes"
import axios, {AxiosError} from "axios"
import {Inertia} from "@inertiajs/inertia"
import {errorsToErrorFields} from "@/admin/inertia/modules/common"
import * as yup from "yup"
import {yupIntegerOrEmptyString} from "@/admin/inertia/utils"
import {Faq} from "@/admin/inertia/modules/faqs/types"
import QuestionAnswerTab from "@/admin/inertia/components/faqs/createEdit/tabs/QuestionAnswerTab.vue"
import SeoTab from "@/admin/inertia/components/faqs/createEdit/tabs/SeoTab.vue"


export const storeName = "createEditFaqForm"

export const useCreateEditFaqFormStore = defineStore(storeName, {
    getters: {
        faqFormTitle: (): string => {
            let base = "Справочники: вопросы-ответы: "
            const faqsStore = useFaqsStore()

            base += faqsStore.isCreatingFaqRoute
                ? "добавление"
                : `${faqsStore.faq?.name} - редактирование`

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
                    value: TabEnum.questionAnswer,
                    label: "Вопрос-ответ",
                    is: QuestionAnswerTab,
                },
                {
                    value: TabEnum.seo,
                    label: "SEO",
                    is: SeoTab,
                }
            ]
        }
    },
    actions: {
        async submitCreateEditFaq(
            values: Values,
            ctx: SubmissionContext<Values>
        ): Promise<void> {
            const faqsStore = useFaqsStore()
            const routesStore = useRoutesStore()

            try {
                let faq: Faq

                const formData = valuesToFormData(values)

                if (faqsStore.isCreatingFaqRoute) {
                    const response = await axios.post<{ data: Faq }>(
                        routesStore.route(
                            routeNames.ROUTE_ADMIN_AJAX_FAQ_STORE
                        ),
                        formData,
                        {
                            headers: { "Content-Type": "multipart/form-data" },
                        }
                    )
                    faq = response.data.data
                    Inertia.get(
                        routesStore.route(
                            routeNames.ROUTE_ADMIN_FAQ_EDIT,
                            {
                                admin_faq: faq.id,
                            }
                        )
                    )
                } else {
                    formData.append("_method", "PUT")

                    const response = await axios.post<{ data: Faq }>(
                        routesStore.route(
                            routeNames.ROUTE_ADMIN_AJAX_FAQ_UPDATE,
                            values.id
                        ),
                        formData,
                        {
                            headers: { "Content-Type": "multipart/form-data" },
                        }
                    )
                    faq = response.data.data
                    faqsStore.setEntity(faq)
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
    }
})

export const getFormSchema = () => {
    return yup.object({
        id: yupIntegerOrEmptyString(),
        uuid: yup.string().nullable(),
        name: yup.string().required().max(250),
        slug: yup.string().required().max(250),
        is_active: yup.boolean(),
        parent_id: yupIntegerOrEmptyString(),
        question: yup.string().max(65000).nullable(),
        answer: yup.string().max(65000).nullable(),
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

export const getWatchFaqToFormCb =
    (setValues: (a: object) => any) => (faq: Faq | null) => {
        const {
            id,
            name,
            slug,
            is_active,
            parent_id,
            question,
            answer,
            seo,
        } = faq || {}

        const values = {
            id,
            name,
            slug,
            is_active,
            parent_id,
            question,
            answer,
            seo,
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
        "question",
        "answer",
    ]

    stringOrNumberKeys.forEach((key) => {
        let value = values[key] as string | number | null | undefined
        formData.setStringOrNumber(key, value)
    })

    let booleanKeys: Array<keyof Values> = [
        "is_active",
    ]

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

    return formData
}
