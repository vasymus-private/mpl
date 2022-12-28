import { defineStore } from "pinia"
import {
    ArticlesResponse,
    Values,
} from "@/admin/inertia/modules/forms/indexArticles/types"
import { routeNames, useRoutesStore } from "@/admin/inertia/modules/routes"
import axios, { AxiosError } from "axios"
import { arrayToMap } from "@/admin/inertia/utils"
import { ArticleListItem } from "@/admin/inertia/modules/articles/types"
import useFormHelpers from "@/admin/inertia/composables/useFormHelpers"
import { ErrorResponse } from "@/admin/inertia/modules/common/types"
import * as yup from "yup"
import { useArticlesStore } from "@/admin/inertia/modules/articles"

export const storeName = "indexArticlesForm"

export const useIndexArticlesFormStore = defineStore(storeName, {
    actions: {
        async submitIndexArticles(
            checkedArticles: Array<string>,
            values: Values
        ): Promise<void | Record<string, string | undefined>> {
            try {
                let articlesToUpdate = values.articles.filter((item) =>
                    checkedArticles.includes(item.uuid)
                )
                if (!articlesToUpdate.length) {
                    return
                }
                const routesStore = useRoutesStore()
                const {
                    data: { data: articlesResponse = [] },
                } = await axios.put<ArticlesResponse>(
                    routesStore.route(
                        routeNames.ROUTE_ADMIN_AJAX_ARTICLE_BULK_UPDATE
                    ),
                    {
                        articles:
                            arrayToMap<Partial<ArticleListItem>>(
                                articlesToUpdate
                            ),
                    }
                )

                const articlesStore = useArticlesStore()
                articlesStore.addOrUpdateArticlesListItems(articlesResponse)
            } catch (e) {
                if (e instanceof AxiosError) {
                    const { errorsToErrorFields } = useFormHelpers<Values>(
                        "articles",
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
        articles: yup.array().of(
            yup.object({
                id: yup.number().required(),
                uuid: yup.string().max(36).required(),
                name: yup.string().required().max(250),
                is_active: yup.boolean(),
            })
        ),
    })
