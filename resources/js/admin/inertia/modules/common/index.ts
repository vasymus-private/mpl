import Meta, {MetaLink} from "@/admin/inertia/modules/common/Meta"
import {isNumeric} from "@/admin/inertia/utils";


export const extendMetaLinksWithComputedData = (meta: Meta): Meta => {
    meta.links.forEach((metaLink: MetaLink, index: number) => {
        const labelIsNumeric = isNumeric(metaLink.label)

        metaLink.isSeparator = metaLink.label !== '...'
        metaLink.isPrev = !labelIsNumeric && index === 0 && metaLink.label !== '...'
        metaLink.isNext = !labelIsNumeric && index !== 0 && metaLink.label !== '...'

        if (labelIsNumeric) {
            metaLink.page = +metaLink.label
        }
    })

    return meta
}

export const extendUrlWithParams = (url: string, {page} : {page: string|number}): string => {
    const _url = new URL(url)
    _url.searchParams.set('page', `${page}`)

    return _url.toString()
}
