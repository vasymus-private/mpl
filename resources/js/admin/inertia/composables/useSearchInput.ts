import { computed, Ref, ref } from "vue"
import useRoute from "@/admin/inertia/composables/useRoute"
import { UrlParams } from "@/admin/inertia/modules/common/types"
import Option from "@/admin/inertia/modules/common/Option"

export default (
    adminOptions?: Ref<Array<Option>>
) => {
    const { getUrlParam, visit } = useRoute()

    const _getRefOrUrlParam = (
        r: Ref<string | null>,
        param: UrlParams
    ): string | null => {
        if (r.value) {
            return r.value
        }

        let urlParam = getUrlParam(param)

        return urlParam ? `${urlParam}` : null
    }

    const _searchInput = ref<string | null>(null)
    const searchInput = computed<string | null>({
        get() {
            return _getRefOrUrlParam(_searchInput, UrlParams.search)
        },
        set(v: string | null) {
            _searchInput.value = v
        },
    })

    const _dateFrom = ref<string | null>(null)
    const dateFrom = computed<string | null>({
        get(): string | null {
            return _getRefOrUrlParam(_dateFrom, UrlParams.date_from)
        },
        set(v: string | null): void {
            _dateFrom.value = v
        },
    })

    const _dateTo = ref<string | null>(null)
    const dateTo = computed<string | null>({
        get(): string | null {
            return _getRefOrUrlParam(_dateTo, UrlParams.date_to)
        },
        set(v: string | null): void {
            _dateTo.value = v
        },
    })

    const _orderId = ref<string | null>(null)
    const orderId = computed<string | null>({
        get(): string | null {
            return _getRefOrUrlParam(_orderId, UrlParams.order_id)
        },
        set(v: string | null): void {
            _orderId.value = v
        },
    })

    const _email = ref<string | null>(null)
    const email = computed<string | null>({
        get(): string | null {
            return _getRefOrUrlParam(_email, UrlParams.email)
        },
        set(v: string | null): void {
            _email.value = v
        },
    })

    const _name = ref<string | null>(null)
    const name = computed<string | null>({
        get(): string | null {
            return _getRefOrUrlParam(_name, UrlParams.name)
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

            let urlParam = getUrlParam(UrlParams.admin_id)

            return adminOptions.value.find(
                (o) => `${o.value}` === `${urlParam}`
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
                    final = map[urlParam]?.value?.value
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
