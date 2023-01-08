import { Column, ResizeColumnType } from "@/admin/inertia/modules/columns/types"
import { useResizeObserver } from "@vueuse/core"
import { ref } from "vue"
import { useColumnsStore } from "@/admin/inertia/modules/columns"

export default (type: ResizeColumnType) => {
    let stopObserveCbs = ref<Array<() => void>>([])
    const columnsStore = useColumnsStore()

    const handleObserveResizingRef = (el: any, column: Column) => {
        let first = ref<boolean>(false)
        const { stop } = useResizeObserver(
            el as HTMLDivElement,
            (entries: Array<ResizeObserverEntry>) => {
                if (!entries.length) {
                    return
                }

                if (!first.value) {
                    first.value = true
                    return
                }

                columnsStore.setSomeColumnResized(type, true)

                columnsStore.setTempColumnSize(
                    type,
                    column,
                    entries[0].contentRect.width
                )
            }
        )
        stopObserveCbs.value.push(stop)
    }

    const stopObserving = () => {
        stopObserveCbs.value.forEach((stop) => stop())
    }

    return {
        stopObserving,
        handleObserveResizingRef,
    }
}
