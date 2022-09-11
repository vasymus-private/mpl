import { defineStore } from "pinia"
import { useCategoriesStore } from "@/admin/inertia/modules/categories"

export const storeName = "createEditCategoryForm"

export const useCreateEditCategoryFormStore = defineStore(storeName, {
    getters: {
        categoryFormTitle: (): string => {
            let base = "Товары: раздел: "
            const categoriesStore = useCategoriesStore()

            base += categoriesStore.isCreatingCategoryRoute
                ? "добавление"
                : `${categoriesStore.category?.name} - редактирование`

            return base
        },
    },
})
