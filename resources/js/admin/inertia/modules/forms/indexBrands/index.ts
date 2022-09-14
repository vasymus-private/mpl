import { defineStore } from "pinia"
import { Values } from "@/admin/inertia/modules/forms/indexBrands/types"
import * as yup from "yup"
import { yupIntegerOrEmptyString } from "@/admin/inertia/utils"

export const storeName = "indexBrandsForm"

export const useIndexBrandsFormStore = defineStore(storeName, {
    actions: {
        async submitIndexBrands(
            checkedBrands: Array<number>,
            values: Values
        ): Promise<void | Record<string, string | undefined>> {},
    },
})

export const getValidationSchema = () =>
    yup.object({
        categories: yup.array().of(
            yup.object({
                id: yup.number().required(),
                ordering: yupIntegerOrEmptyString(),
                name: yup.string().required().max(250),
                description: yup.boolean(),
            })
        ),
    })
