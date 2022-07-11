export interface AdminTab {
    value: TabEnum,
    label: string,
}

export enum TabEnum {
    elements = 'elements',
    description = 'description',
    photo = 'photo',
    characteristics = 'characteristics',
    seo = 'seo',
    accessories = 'accessories',
    similar = 'similar',
    related = 'related',
    works = 'works',
    instruments = 'instruments',
    variations = 'variations',
    other = 'other',
}
