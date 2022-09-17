import { computed, Ref, ref } from "vue"
import useRoute, { UrlParams } from "@/admin/inertia/composables/useRoute"
import Option from "@/admin/inertia/modules/common/Option"

export default (
    fullUrl?: Ref<string | null>,
    adminOptions?: Ref<Array<Option>>
) => {
    const { getUrlParam, visit } = useRoute(fullUrl)

    const _searchInput = ref<string | null>(null)
    const searchInput = computed<string | null>({
        get() {
            return _searchInput.value
                ? _searchInput.value
                : getUrlParam(UrlParams.search)
        },
        set(v: string | null) {
            _searchInput.value = v
        },
    })

    const _dateFrom = ref<string | null>(null)
    const dateFrom = computed<string | null>({
        get(): string | null {
            return _dateFrom.value
                ? _dateFrom.value
                : getUrlParam(UrlParams.date_from)
        },
        set(v: string | null): void {
            _dateFrom.value = v
        },
    })

    const _dateTo = ref<string | null>(null)
    const dateTo = computed<string | null>({
        get(): string | null {
            return _dateTo.value
                ? _dateTo.value
                : getUrlParam(UrlParams.date_to)
        },
        set(v: string | null): void {
            _dateTo.value = v
        },
    })

    const _orderId = ref<string | null>(null)
    const orderId = computed<string | null>({
        get(): string | null {
            return _orderId.value
                ? _orderId.value
                : getUrlParam(UrlParams.order_id)
        },
        set(v: string | null): void {
            _orderId.value = v
        },
    })

    const _email = ref<string | null>(null)
    const email = computed<string | null>({
        get(): string | null {
            return _email.value ? _email.value : getUrlParam(UrlParams.email)
        },
        set(v: string | null): void {
            _email.value = v
        },
    })

    const _name = ref<string | null>(null)
    const name = computed<string | null>({
        get(): string | null {
            return _name.value ? _name.value : getUrlParam(UrlParams.name)
        },
        set(v: string | null): void {
            _name.value = v
        },
    })

    const _admin = ref<Option | null>(null)
    const admin = computed<Option | null>({
        get(): Option | null {
            if (_admin.value) {
                return _admin.value
            }

            return adminOptions.value.find(
                (o) => `${o.value}` === `${getUrlParam(UrlParams.admin_id)}`
            )
        },
        set(v: Option | null): void {
            _admin.value = v
        },
    })

    const map = {
        [UrlParams.search]: searchInput,
        [UrlParams.date_from]: dateFrom,
        [UrlParams.date_to]: dateTo,
        [UrlParams.order_id]: orderId,
        [UrlParams.email]: email,
        [UrlParams.name]: name,
        [UrlParams.admin_id]: admin,
    }

    const onPerPage = (perPage: Option) => {
        visit({
            [UrlParams.page]: 1,
            [UrlParams.per_page]: perPage.value,
        })
    }
    const handleSearch = () => {
        visit({
            [UrlParams.search]: searchInput.value,
        })
    }
    const handleClearSearch = () => {
        visit({
            [UrlParams.search]: null,
        })
    }

    const handleOrdersSearch = () => {
        visitWithInputs([
            UrlParams.date_from,
            UrlParams.date_to,
            UrlParams.order_id,
            UrlParams.email,
            UrlParams.name,
            UrlParams.admin_id,
        ])
    }

    const cancelOrdersSearch = () => {
        visitWithNullInputs([
            UrlParams.date_from,
            UrlParams.date_to,
            UrlParams.order_id,
            UrlParams.email,
            UrlParams.name,
            UrlParams.admin_id,
        ])
    }

    const visitWithInputs = (inputs: Array<UrlParams>) => {
        let visitParams: Partial<Record<UrlParams, string | number | null>> = {}

        inputs.forEach((urlParam) => {
            let final
            switch (urlParam) {
                case UrlParams.admin_id: {
                    final = map[urlParam]?.value.value
                    break
                }
                default: {
                    final = map[urlParam]?.value
                    break
                }
            }
            visitParams = {
                ...visitParams,
                [urlParam]: final,
            }
        })

        visit(visitParams)
    }

    const visitWithNullInputs = (inputs: Array<UrlParams>) => {
        let visitParams: Partial<Record<UrlParams, string | number | null>> = {}

        inputs.forEach((urlParam) => {
            visitParams = {
                ...visitParams,
                [urlParam]: null,
            }
        })

        visit(visitParams)
    }

    return {
        searchInput,
        dateFrom,
        dateTo,
        orderId,
        email,
        name,
        admin,
        onPerPage,
        handleSearch,
        handleClearSearch,
        visitWithInputs,
        visitWithNullInputs,
        handleOrdersSearch,
        cancelOrdersSearch,
    }
}
