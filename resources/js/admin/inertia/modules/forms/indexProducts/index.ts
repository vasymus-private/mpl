import * as yup from "yup"
import {yupIntegerOrEmptyString, yupNumberOrEmptyString} from "@/admin/inertia/utils"
import {getRouteUrl, routeNames} from "@/admin/inertia/modules/routes"
import axios, {AxiosError} from "axios"
import {Ref} from "vue"
import ProductListItem from "@/admin/inertia/modules/products/ProductListItem"
import {SubmissionHandler} from 'vee-validate'
import {defineStore} from "pinia";
import {useProductsStore} from "@/admin/inertia/modules/products";


export const storeName = "indexProductsForm"

export const useIndexProductsFormStore = defineStore(storeName, {
    actions: {
        getSubmitCb(checkedProducts: Ref<Array<number>>): SubmissionHandler<{products: Array<Partial<ProductListItem>>}> {
            return async (values: Values, {setErrors, ...restActions}) => {
                console.log('---', values, restActions)

                try {
                    let productsToUpdate = values.products.filter((item) => checkedProducts.value.includes(item.id))
                    if (!productsToUpdate.length) {
                        return
                    }
                    const {data: { data: productsResponse = [] }} = await axios.put<ProductsResponse>(getRouteUrl(routeNames.ROUTE_ADMIN_AJAX_PRODUCTS_BULK_UPDATE), {
                        products:
                            productsToUpdate
                                .reduce((acc, item) => ({
                                    ...acc,
                                    [item.id]: item,
                                }), {}),
                    })

                    const productsStore = useProductsStore()
                    productsStore.addOrUpdateProductListItems(productsResponse)
                } catch (e) {
                    if (e instanceof AxiosError) {
                        const indexForId = getIndexForIdCb(values)
                        const {data : {errors}} : { data : { errors: Errors } } = e.response

                        let errorFields = {}

                        for (let key in errors) {
                            let id = parseIdErrorProductResponse(key)
                            let fieldName = parseFieldErrorProductResponse(key)
                            let index = indexForId(id)

                            errorFields = {
                                ...errorFields,
                                [`products[${index}].${fieldName}`]: errors[key].join(', '),
                            }
                        }

                        setErrors(errorFields)
                        return
                    }
                    throw e
                }
            }
        }
    }
})


export const getValidationSchema = () => yup.object({
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
    )
})

interface ProductsResponse {
    data: Array<ProductListItem>
}
interface Values {
    products: Array<Partial<ProductListItem>>
}
interface Errors {
    [key: string]: Array<string>
}

const parseIdErrorProductResponse = (key: string): number => +key.split('.')[1]
const parseFieldErrorProductResponse = (key: string): string => key.split('.')[2]

export const getIndexForIdCb = (values: Values) => (id: number) => values.products.findIndex(item => item.id === id)
