import Meta, { MetaLink } from "@/admin/inertia/modules/common/Meta"
import { isNumeric } from "@/admin/inertia/utils"
import axios from "axios"
import { getRouteUrl, routeNames } from "@/admin/inertia/modules/routes"
import {Errors} from "@/admin/inertia/modules/common/types";

export const extendMetaLinksWithComputedData = (
    meta: Meta,
    fullUrl: string | null
): Meta => {
    meta.links.forEach((metaLink: MetaLink, index: number) => {
        const labelIsNumeric = isNumeric(metaLink.label)

        metaLink.isSeparator = metaLink.label === "..."
        metaLink.isPrev =
            !labelIsNumeric && index === 0 && metaLink.label !== "..."
        metaLink.isNext =
            !labelIsNumeric && index !== 0 && metaLink.label !== "..."

        if (labelIsNumeric) {
            metaLink.page = +metaLink.label
        }

        if (!labelIsNumeric && (metaLink.isPrev || metaLink.isNext)) {
            metaLink.page = extractPageParamFromUrl(metaLink.url)
        }

        metaLink.url = extendUrlWithCurrentParams(metaLink.url, fullUrl)
    })

    return meta
}

export const extendUrlWithCurrentParams = (
    url: string | null,
    fullUrl: string | null
): string | null => {
    if (!url) {
        return null
    }

    try {
        const _url = new URL(url)
        const _fullUrl: string | null = fullUrl
            ? fullUrl
            : typeof location !== "undefined"
            ? location.href
            : null
        const currentUrl = new URL(_fullUrl)

        currentUrl.searchParams.set("page", _url.searchParams.get("page"))

        return currentUrl.toString()
    } catch (e) {
        return null
    }
}

export const extractPageParamFromUrl = (url: string | null): number | null => {
    if (!url) {
        return null
    }

    try {
        const _u = new URL(url)
        const page = _u.searchParams.get("page")
        return page && isNumeric(page) ? +page : null
    } catch (e) {
        return null
    }
}

export const extendUrlWithParams = (
    url: string,
    { page }: { page: string | number }
): string => {
    const _url = new URL(url)
    _url.searchParams.set("page", `${page}`)

    return _url.toString()
}

interface SlugifyResponse {
    data: string
}

export const slugify = async (
    title: string,
    separator?: string,
    language?: string
): Promise<string> => {
    const {
        data: { data: slug },
    } = await axios.post<SlugifyResponse>(
        getRouteUrl(routeNames.ROUTE_ADMIN_AJAX_HELPER, {
            title,
            separator,
            language,
        })
    )

    return slug
}

export const getActiveName = (is_active: boolean | null) =>
    is_active ? "Да" : "Нет"


export const errorsToErrorFields = (
    errors: Errors
): Record<string, string | undefined> => {
    let errorFields = {}

    for (let key in errors) {
        errorFields = {
            ...errorFields,
            [key]: errors[key].join(" "),
        }
    }

    return errorFields
}
