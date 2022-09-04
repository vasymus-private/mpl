import {defineStore} from "pinia"
import * as yup from "yup"
import {yupIntegerOrEmptyString} from "@/admin/inertia/utils"
import {Values} from "@/admin/inertia/modules/forms/indexCategories/types"
import {Ref} from "vue"

export const storeName = "indexProductsForm"

export const useIndexCategoriesFormStore = defineStore(storeName, {
    actions: {
        async submitIndexCategories(
            checkedCategories: Ref<Array<number>>,
            values: Values,
            { setErrors }
        ): Promise<void> {

        },
    }
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
        )
    })

export const getIndexForIdCb =
    (values: Values): ((id: number) => number | -1) =>
        (id: number) =>
            values.categories.findIndex((item) => item.id === id)
