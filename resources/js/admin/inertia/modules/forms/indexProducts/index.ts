import * as yup from "yup"
import {
    arrayToMap,
    yupIntegerOrEmptyString,
    yupNumberOrEmptyString,
} from "@/admin/inertia/utils"
import {
    getRouteUrl,
    routeNames,
    useRoutesStore,
} from "@/admin/inertia/modules/routes"
import axios, { AxiosError } from "axios"
import ProductListItem from "@/admin/inertia/modules/products/ProductListItem"
import { defineStore } from "pinia"
import { useProductsStore } from "@/admin/inertia/modules/products"
import {
    ProductsResponse,
    Values,
} from "@/admin/inertia/modules/forms/indexProducts/types"
import useFormHelpers from "@/admin/inertia/composables/useFormHelpers"
import { ErrorResponse } from "@/admin/inertia/modules/common/types"

export const storeName = "indexProductsForm"

export const useIndexProductsFormStore = defineStore(storeName, {
    actions: {
        async submitIndexProducts(
            checkedProducts: Array<number>,
            values: Values
        ): Promise<void | Record<string, string | undefined>> {
            try {
                let productsToUpdate = values.products.filter((item) =>
                    checkedProducts.includes(item.id)
                )
                if (!productsToUpdate.length) {
                    return
                }
                const {
                    data: { data: productsResponse = [] },
                } = await axios.put<ProductsResponse>(
                    getRouteUrl(
                        routeNames.ROUTE_ADMIN_AJAX_PRODUCTS_BULK_UPDATE
                    ),
                    {
                        products:
                            arrayToMap<Partial<ProductListItem>>(
                                productsToUpdate
                            ),
                    }
                )

                const productsStore = useProductsStore()
                productsStore.addOrUpdateProductListItems(productsResponse)
            } catch (e) {
                if (e instanceof AxiosError) {
                    const { errorsToErrorFields } = useFormHelpers<Values>(
                        "products",
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
        products: yup.array().of(
            yup.object({
                id: yup.number().required(),
                ordering: yupIntegerOrEmptyString(),
                name: yup.string().required().max(250),
                is_active: yup.boolean(),
                unit: yup.string().max(250).nullable(),
                price_purchase: yupNumberOrEmptyString(),
                price_purchase_currency_id: yupIntegerOrEmptyString(),
                price_retail: yupNumberOrEmptyString(),
                price_retail_currency_id: yupIntegerOrEmptyString(),
                availability_status_id: yupIntegerOrEmptyString(),
                admin_comment: yup.string().max(250).nullable(),
            })
        ),
    })
