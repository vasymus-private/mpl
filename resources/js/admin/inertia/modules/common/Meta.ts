export default interface Meta {
    current_page: number,
    from: number,
    last_page: number,
    path: string,
    per_page: number,
    to: number,
    total: number,
    links: Array<MetaLink>
}

export interface MetaLink {
    active: boolean,
    label: string,
    url: string|null,
}
