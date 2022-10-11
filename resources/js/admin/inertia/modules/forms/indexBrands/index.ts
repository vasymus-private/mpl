import { defineStore } from "pinia"
import {
    BrandsResponse,
    Values,
} from "@/admin/inertia/modules/forms/indexBrands/types"
import * as yup from "yup"
import { arrayToMap, yupIntegerOrEmptyString } from "@/admin/inertia/utils"
import axios, { AxiosError } from "axios"
import { routeNames, useRoutesStore } from "@/admin/inertia/modules/routes"
import useFormHelpers from "@/admin/inertia/composables/useFormHelpers"
import { ErrorResponse } from "@/admin/inertia/modules/common/types"
import { useBrandsStore } from "@/admin/inertia/modules/brands"
import { BrandListItem } from "@/admin/inertia/modules/brands/types"

export const storeName = "indexBrandsForm"

export const useIndexBrandsFormStore = defineStore(storeName, {
    actions: {
        async submitIndexBrands(
            checkedBrands: Array<string>,
            values: Values
        ): Promise<void | Record<string, string | undefined>> {
            try {
                let brandsToUpdate = values.brands.filter((item) =>
                    checkedBrands.includes(item.uuid)
                )
                if (!brandsToUpdate.length) {
                    return
                }
                const routesStore = useRoutesStore()
                const {
                    data: { data: brandsResponse = [] },
                } = await axios.put<BrandsResponse>(
                    routesStore.route(
                        routeNames.ROUTE_ADMIN_AJAX_BRANDS_BULK_UPDATE
                    ),
                    {
                        brands: arrayToMap<Partial<BrandListItem>>(
                            brandsToUpdate
                        ),
                    }
                )

                const brandsStore = useBrandsStore()
                brandsStore.addOrUpdateBrandsListItems(brandsResponse)
            } catch (e) {
                if (e instanceof AxiosError) {
                    const { errorsToErrorFields } = useFormHelpers<Values>(
                        "brands",
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
        brands: yup.array().of(
            yup.object({
                id: yup.number().required(),
                ordering: yupIntegerOrEmptyString(),
                name: yup.string().required().max(250),
                preview: yup.string().max(65000).nullable(),
            })
        ),
    })
