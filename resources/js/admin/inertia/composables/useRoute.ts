import { Inertia } from "@inertiajs/inertia"
import { isNumeric } from "@/admin/inertia/utils"
import { UrlParams } from "@/admin/inertia/modules/common/types"
import { usePage } from "@inertiajs/inertia-vue3"
import { InitialPageProps } from "@/admin/inertia/modules"

export default () => {
    const pageProps = usePage<InitialPageProps>()
    const fullUrl = pageProps.props.value.fullUrl

    const _getUrl = (): string =>
        typeof location !== "undefined" ? location.href : fullUrl

    const getUrlParam = (key: string): string | number | boolean | null => {
        if (!_getUrl()) {
            return null
        }

        try {
            let u = new URL(_getUrl())
            let value = u.searchParams.get(key)

            switch (true) {
                case "true" === value: {
                    return true
                }
                case "false" === value: {
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
        if (!_getUrl()) {
            return false
        }

        try {
            let u = new URL(_getUrl())
            return u.searchParams.has(key)
        } catch (e) {
            console.warn(e)
            return false
        }
    }

    const visit = (
        params: Partial<Record<UrlParams, string | number | null>>
    ) => {
        const to = new URL(_getUrl())

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
        Inertia.visit(new URL(_getUrl()).toString())
    }

    const visitWithoutUrlParam = (param: UrlParams) => {
        visit({
            [param]: null,
        })
    }

    return {
        getUrlParam,
        visit,
        revisit,
        hasUrlParam,
        visitWithoutUrlParam,
    }
}
