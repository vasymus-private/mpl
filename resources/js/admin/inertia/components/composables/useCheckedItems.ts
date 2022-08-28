import {Ref, ref} from 'vue'
import {WithId} from "@/admin/inertia/modules/common/types"


export default <T extends WithId>(items: Ref<Array<T>>) => {
    const checkedItems: Ref<Array<T['id']>> = ref([])

    const checkAll = () => {
        checkedItems.value = items.value.map((item: T) => item.id)
    }

    const uncheckAll = () => {
        checkedItems.value = []
    }

    const check = (id: T['id']) => {
        const isChecked = !!checkedItems.value.find(_id => +id === +_id)
        if (isChecked) {
            checkedItems.value = checkedItems.value.filter(_id => +_id !== +id)
            return
        }

        checkedItems.value = [...checkedItems.value, id]
    }

    const isChecked = (id: T['id']): boolean => {
        return checkedItems.value.includes(id)
    }

    return {
        checkedItems,
        checkAll,
        uncheckAll,
        check,
        isChecked,
    }
}

