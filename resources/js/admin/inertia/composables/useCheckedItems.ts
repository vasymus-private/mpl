import { Ref, ref, watch } from "vue"
import { WithUuid } from "@/admin/inertia/modules/common/types"

export default <T extends WithUuid>(items: Ref<Array<T>>) => {
    const selectAll = ref(false)
    const editMode = ref(false)
    const checkedItems: Ref<Array<T["uuid"]>> = ref([])

    const checkAll = () => {
        checkedItems.value = items.value.map((item: T) => item.uuid)
    }

    const uncheckAll = () => {
        checkedItems.value = []
    }

    const check = (uuid: T["uuid"]) => {
        const isChecked = !!checkedItems.value.find((_uuid) => +uuid === +_uuid)
        if (isChecked) {
            checkedItems.value = checkedItems.value.filter(
                (_uuid) => +_uuid !== +uuid
            )
            return
        }

        checkedItems.value = [...checkedItems.value, uuid]
    }

    const isChecked = (uuid: T["uuid"]): boolean => {
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
