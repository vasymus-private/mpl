import { defineStore } from "pinia"
import * as yup from "yup"
import { arrayToMap, yupIntegerOrEmptyString } from "@/admin/inertia/utils"
import {
    CategoriesResponse,
    Values,
} from "@/admin/inertia/modules/forms/indexCategories/types"
import axios, { AxiosError } from "axios"
import { routeNames, useRoutesStore } from "@/admin/inertia/modules/routes"
import useFormHelpers from "@/admin/inertia/composables/useFormHelpers"
import { useCategoriesStore } from "@/admin/inertia/modules/categories"
import { ErrorResponse } from "@/admin/inertia/modules/common/types"
import { CategoryListItem } from "@/admin/inertia/modules/categories/types"

export const storeName = "indexCategoriesForm"

export const useIndexCategoriesFormStore = defineStore(storeName, {
    actions: {
        async submitIndexCategories(
            checkedCategoriesUuids: Array<string>,
            values: Values
        ): Promise<void | Record<string, string | undefined>> {
            try {
                let categoriesToUpdate = values.categories.filter((item) =>
                    checkedCategoriesUuids.includes(item.uuid)
                )
                if (!categoriesToUpdate.length) {
                    return
                }
                const routesStore = useRoutesStore()
                const {
                    data: { data: categoriesResponse = [] },
                } = await axios.put<CategoriesResponse>(
                    routesStore.route(
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
