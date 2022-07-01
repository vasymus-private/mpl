import { defineStore } from "pinia"
import CategoryTreeItem from "@/admin/inertia/entities/CategoryTreeItem"

export const storeName = "categoriesTree"

export const useCategoriesTreeStore = defineStore(storeName, {
    state: (): { entities: Array<CategoryTreeItem> } => {
        return {
            entities: [],
        }
    },
    getters: {
        getCategoryAndSubtreeIds:
            (state) =>
            (id): Array<number> | null => {
                let categoryAndSubcategories = getCategoryAndSubcategoryCb(
                    state.entities,
                    id
                )

                if (!categoryAndSubcategories) {
                    return null
                }

                return getIdsCb([], categoryAndSubcategories)
            },
        categories: (state) : Array<CategoryTreeItem> => state.entities
    },
    actions: {
        setEntities(entities: Array<CategoryTreeItem>): void {
            this.entities = entities
        },
    },
})

let getCategoryAndSubcategoryCb = (
    categories: Array<CategoryTreeItem>,
    _id
): CategoryTreeItem | null => {
    for (let i = 0; i < categories.length; i++) {
        if (categories[i].id === _id) {
            return categories[i]
        }

        let res = getCategoryAndSubcategoryCb(categories[i].subcategories, _id)
        if (res) {
            return res
        }
    }

    return null
}

let getIdsCb = (
    acc: Array<number>,
    category: CategoryTreeItem
): Array<number> => {
    acc = [...acc, category.id]
    for (let i = 0; i < category.subcategories.length; i++) {
        acc = getIdsCb(acc, category.subcategories[i])
    }
    return acc
}
