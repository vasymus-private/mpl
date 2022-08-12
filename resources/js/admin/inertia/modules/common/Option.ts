export default interface Option {
    value: string | number
    label: string
    disabled?: boolean
    type?: OptionType
}

export enum OptionType {
    category = 'category',
    brand = 'brand',
}
