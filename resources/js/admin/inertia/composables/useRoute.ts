import { Ref } from "vue"
import { Inertia } from "@inertiajs/inertia"
import { AdminTab } from "@/admin/inertia/modules/common/Tabs"
import {isNumeric} from "@/admin/inertia/utils"
import {computed} from 'vue'

export enum UrlParams {
    brand_id = "brand_id",
    category_id = "category_id",
    page = "page",
    per_page = "per_page",
    search = "search",

    date_from = "date_from",
    date_to = "date_to",
    order_id = "order_id",
    email = "email",
    name = "name",
    admin_id = "admin_id",

    copy_id = "copy_id",

    active_tab = "active_tab",
}

export default (fullUrl?: Ref<string | null>) => {
    const _url = computed<string|null>(() => typeof location !== "undefined"
        ? location.href
        : fullUrl
            ? fullUrl.value
            : null)

    const getUrlParam = (key: string): string | number | boolean | null => {
        if (!_url.value) {
            return null
        }

        try {
            let u = new URL(_url.value)
            let value = u.searchParams.get(key)

            switch (true) {
                case 'true' === value: {
                    return true
                }
                case 'false' === value: {
                    return false
                }
                case isNumeric(value): {
                    return +value
                }
                default: {
                    return value
                }
            }
        } catch (e) {
            console.warn(e)
            return null
        }
    }

    const hasUrlParam = (key: string): boolean => {
        if (!_url.value) {
            return false
        }

        try {
            let u = new URL(_url.value)
            return u.searchParams.has(key)
        } catch (e) {
            console.warn(e)
            return false
        }
    }

    const visit = (
        params: Partial<Record<UrlParams, string | number | null>>
    ) => {
        const to = new URL(_url.value)

        for (let key in params) {
            if (params[key]) {
                to.searchParams.set(key, `${params[key]}`)
            } else {
                to.searchParams.delete(key)
            }
        }

        Inertia.visit(to.toString())
    }

    const revisit = () => {
        Inertia.visit(new URL(_url.value).toString())
    }

    const visitWithoutUrlParam = (param: UrlParams) => {
        visit({
            [param]: null,
        })
    }

    const onTabClick = (tab: AdminTab) => {
        setUrlParam(UrlParams.active_tab, tab.value)
    }

    const setUrlParam = (key: UrlParams, value: string|number|boolean|null) => {
        let u = new URL(_url.value)
        let s = new URLSearchParams(u.search)

        switch (true) {
            case value == null : {
                s.delete(key)
                break
            }
            case typeof value === 'boolean': {
                s.set(key, value ? 'true' : 'false')
                break
            }
            default: {
                s.set(key, `${value}`)
                break
            }
        }

        u.search = s.toString()
        history.replaceState(history.state, "", u.toString())
    }

    return {
        getUrlParam,
        visit,
        onTabClick,
        revisit,
        hasUrlParam,
        visitWithoutUrlParam,
    }
}
