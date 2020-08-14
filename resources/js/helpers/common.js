export const numberWithSpaces = num => {
    let parts = num.toString().split(".")
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, " ")
    return parts.join(".")
}

export const arrayPrimitivesToObj = (arr, fill = null) => arr.reduce(
    (res, curr) => {
        res = {...res, [curr] : fill}
        return res
    },
    {}
)
