import { defineStore } from "pinia"
import { useArticlesStore } from "@/admin/inertia/modules/articles"
import {
    AdminTab,
    ErrorResponse,
    TabEnum,
} from "@/admin/inertia/modules/common/types"
import ElementsTab from "@/admin/inertia/components/articles/createEdit/tabs/ElementsTab.vue"
import DescriptionTab from "@/admin/inertia/components/articles/createEdit/tabs/DescriptionTab.vue"
import SeoTab from "@/admin/inertia/components/articles/createEdit/tabs/SeoTab.vue"
import { Values } from "@/admin/inertia/modules/forms/createEditArticle/types"
import { SubmissionContext } from "vee-validate"
import { routeNames, useRoutesStore } from "@/admin/inertia/modules/routes"
import axios, { AxiosError } from "axios"
import { Inertia } from "@inertiajs/inertia"
import { errorsToErrorFields } from "@/admin/inertia/modules/common"
import * as yup from "yup"
import { yupIntegerOrEmptyString } from "@/admin/inertia/utils"
import { Article } from "@/admin/inertia/modules/articles/types"


export const storeName = "createEditArticleForm"

export const useCreateEditArticleFormStore = defineStore(storeName, {
    getters: {
        articleFormTitle: (): string => {
            let base = "Справочники: статьи: "
            const articlesStore = useArticlesStore()

            base += articlesStore.isCreatingArticleRoute
                ? "добавление"
                : `${articlesStore.article?.name} - редактирование`

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
                    value: TabEnum.seo,
                    label: "SEO",
                    is: SeoTab,
                },
            ]
        },
    },
    actions: {
        async submitCreateEditArticle(
            values: Values,
            ctx: SubmissionContext<Values>
        ): Promise<void> {
            const articlesStore = useArticlesStore()
            const routesStore = useRoutesStore()

            try {
                let article: Article

                const formData = valuesToFormData(values)

                if (articlesStore.isCreatingArticleRoute) {
                    const response = await axios.post<{ data: Article }>(
                        routesStore.route(
                            routeNames.ROUTE_ADMIN_AJAX_ARTICLE_STORE
                        ),
                        formData,
                        {
                            headers: { "Content-Type": "multipart/form-data" },
                        }
                    )
                    article = response.data.data
                    Inertia.get(
                        routesStore.route(routeNames.ROUTE_ADMIN_ARTICLES_EDIT, {
                            admin_article: article.id,
                        })
                    )
                } else {
                    formData.append("_method", "PUT")

                    const response = await axios.post<{ data: Article }>(
                        routesStore.route(
                            routeNames.ROUTE_ADMIN_AJAX_ARTICLE_UPDATE,
                            values.id
                        ),
                        formData,
                        {
                            headers: { "Content-Type": "multipart/form-data" },
                        }
                    )
                    article = response.data.data
                    articlesStore.setEntity(article)
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
    })
}

export const getWatchArticleToFormCb =
    (setValues: (a: object) => any) => (article: Article | null) => {
        const { id, name, slug, is_active, parent_id, description, seo } =
        article || {}

        const values = {
            id,
            name,
            slug,
            is_active,
            parent_id,
            description,
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

    return formData
}
