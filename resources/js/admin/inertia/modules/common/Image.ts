export default interface Image {
    id: number | null
    uuid: string | null
    url: string | null
    name: string | null
    file_name: string | null
    order_column?: number | null
    file: File | null
}
