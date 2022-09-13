import { defineStore } from "pinia"
import * as yup from "yup"
import { arrayToMap, yupIntegerOrEmptyString } from "@/admin/inertia/utils"
import {
    CategoriesResponse,
    Values,
} from "@/admin/inertia/modules/forms/indexCategories/types"
import { Ref } from "vue"
import axios, { AxiosError } from "axios"
import {getRouteUrl, routeNames, useRoutesStore} from "@/admin/inertia/modules/routes"
import useFormHelpers from "@/admin/inertia/composables/useFormHelpers"
import { useCategoriesStore } from "@/admin/inertia/modules/categories"
import { ErrorResponse } from "@/admin/inertia/modules/common/types"
import { CategoryListItem } from "@/admin/inertia/modules/categories/types"
import {errorsToErrorFields} from "@/admin/inertia/modules/common";

export const storeName = "indexCategoriesForm"

export const useIndexCategoriesFormStore = defineStore(storeName, {
    actions: {
        async submitIndexCategories(
            checkedCategories: Array<number>,
            values: Values
        ): Promise<void | Record<string, string | undefined>> {
            try {
                let categoriesToUpdate = values.categories.filter((item) =>
                    checkedCategories.includes(item.id)
                )
                if (!categoriesToUpdate.length) {
                    return
                }
                const {
                    data: { data: categoriesResponse = [] },
                } = await axios.put<CategoriesResponse>(
                    getRouteUrl(
                        routeNames.ROUTE_ADMIN_AJAX_CATEGORIES_BULK_UPDATE
                    ),
                    {
                        categories:
                            arrayToMap<Partial<CategoryListItem>>(
                                categoriesToUpdate
                            ),
                    }
                )

                const categoriesStore = useCategoriesStore()
                categoriesStore.addOrUpdateCategoryListItems(categoriesResponse)
            } catch (e) {
                if (e instanceof AxiosError) {
                    const { errorsToErrorFields } = useFormHelpers<Values>(
                        "categories",
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
        async deleteIndexCategories(
            checkedCategories: Array<number>
        ): Promise<void | Record<string, string | undefined>> {
            if (!checkedCategories.length) {
                return
            }

            const routesStore = useRoutesStore()
            const categoriesStore = useCategoriesStore()

            try {
                let url = new URL(
                    routesStore.route(
                        routeNames.ROUTE_ADMIN_AJAX_CATEGORIES_BULK_DELETE
                    )
                )
                checkedCategories.forEach((id) => {
                    url.searchParams.append("ids[]", `${id}`)
                })
                await axios.delete(url.toString())

                categoriesStore.deleteListItems(checkedCategories)
            } catch (e) {
                if (e instanceof AxiosError) {
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
        categories: yup.array().of(
            yup.object({
                id: yup.number().required(),
                ordering: yupIntegerOrEmptyString(),
                name: yup.string().required().max(250),
                is_active: yup.boolean(),
            })
        ),
    })
