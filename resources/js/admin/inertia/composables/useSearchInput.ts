import { computed, Ref, ref } from "vue"
import useRoute, { UrlParams } from "@/admin/inertia/composables/useRoute"
import Option from "@/admin/inertia/modules/common/Option"

export default (fullUrl?: Ref<string | null>) => {
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

    return {
        searchInput,
        onPerPage,
        handleSearch,
        handleClearSearch,
    }
}
