import { Ref } from "vue"
import { Inertia } from "@inertiajs/inertia"
import { OptionType } from "@/admin/inertia/modules/common/Option"
import {AdminTab} from "@/admin/inertia/modules/common/Tabs"
import {RouteParams} from "@/admin/inertia/modules/routes"

export enum UrlParams {
    brand_id = "brand_id",
    category_id = "category_id",
    page = "page",
    per_page = "per_page",
    search = "search",
}

export default (fullUrl?: Ref<string | null>) => {
    const getUrlParam = (key: string): string | null => {
        let url =
            typeof location !== "undefined"
                ? location.href
                : fullUrl
                ? fullUrl.value
                : null

        if (!url) {
            return null
        }

        try {
            let u = new URL(url)
            return u.searchParams.get(key)
        } catch (e) {
            console.warn(e)
            return null
        }
    }

    const visit = (
        params: Partial<Record<UrlParams, string | number | null>>
    ) => {
        const to = new URL(location.href)

        for (let key in params) {
            if (params[key]) {
                to.searchParams.set(key, `${params[key]}`)
            } else {
                to.searchParams.delete(key)
            }
        }

        Inertia.visit(to.toString())
    }

    const removeUrlParam = (type: OptionType) => {
        switch (type) {
            case OptionType.category: {
                visit({
                    [UrlParams.category_id]: null,
                })
                break
            }
            case OptionType.brand: {
                visit({
                    [UrlParams.brand_id]: null,
                })
                break
            }
        }
    }

    const onTabClick = (tab: AdminTab) => {
        let u = new URL(location.href)
        let s = new URLSearchParams(u.search)
        s.set(RouteParams.activeTab, tab.value)
        u.search = s.toString()
        history.replaceState(history.state, '', u.toString())
    }

    return {
        getUrlParam,
        visit,
        removeUrlParam,
        onTabClick,
    }
}
