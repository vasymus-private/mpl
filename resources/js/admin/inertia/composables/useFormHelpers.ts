import { Errors } from "@/admin/inertia/modules/common/types"

export default <T extends { [K in keyof T]: Array<{ id?: number | string }> }>(
    key: keyof T,
    values: T
) => {
    const getIndexForIdCb = function (
        values: T
    ): (id: number | string) => number | -1 {
        return (id: number) => values[key].findIndex((item) => item.id === id)
    }

    let indexForId: (id: number) => number | -1 = getIndexForIdCb(values)

    const errorsToErrorFields = (
        errors: Errors
    ): Record<string, string | undefined> => {
        let errorFields = {}

        for (let key in errors) {
            let id = parseIdErrorProductResponse(key)
            let fieldName = parseFieldErrorProductResponse(key)
            let index = indexForId(id)

            errorFields = {
                ...errorFields,
                [`products[${index}].${fieldName}`]: errors[key].join(", "),
            }
        }

        return errorFields
    }

    const parseIdErrorProductResponse = (key: string): number =>
        +key.split(".")[1]
    const parseFieldErrorProductResponse = (key: string): string =>
        key.split(".")[2]

    return {
        errorsToErrorFields,
        indexForId,
    }
}
