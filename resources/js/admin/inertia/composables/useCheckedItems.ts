import { Ref, ref, watch } from "vue"
import { WithUuid } from "@/admin/inertia/modules/common/types"

export default <T extends object|WithUuid>(items: Ref<Array<T>>, getUuid? : (item: T) => string) => {
    if (!getUuid) {
        getUuid = (item: T) => ('uuid' in item && typeof item.uuid === 'string') ? item.uuid : ''
    }
    const selectAll = ref(false)
    const editMode = ref(false)
    const checkedItems: Ref<Array<string>> = ref([])

    const checkAll = () => {
        checkedItems.value = items.value.map((item: T) => getUuid(item))
    }

    const uncheckAll = () => {
        checkedItems.value = []
    }

    const check = (uuid: string) => {
        const isChecked = !!checkedItems.value.find((_uuid) => uuid === _uuid)
        if (isChecked) {
            checkedItems.value = checkedItems.value.filter(
                (_uuid) => _uuid !== uuid
            )
            return
        }

        checkedItems.value = [...checkedItems.value, uuid]
    }

    const isChecked = (uuid: string): boolean => {
        return checkedItems.value.includes(uuid)
    }

    const cancel = () => {
        editMode.value = false
        uncheckAll()
    }

    const manualCheck = (uuid: string) => {
        if (editMode.value) {
            return
        }

        check(uuid)
    }

    const watchSelectAll = () => {
        watch(selectAll, (newValue) => {
            if (newValue === true) {
                checkAll()
            }

            if (newValue === false) {
                uncheckAll()
            }
        })
    }

    return {
        selectAll,
        editMode,
        checkedItems,
        checkAll,
        uncheckAll,
        check,
        isChecked,
        watchSelectAll,
        cancel,
        manualCheck,
    }
}
