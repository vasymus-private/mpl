import { defineStore } from "pinia"
import {CategoriesTreeItem, Category, CategoryListItem} from "@/admin/inertia/modules/categoriesTree/types"
import Option from "@/admin/inertia/modules/common/Option"

export const storeName = "categoriesTree"

interface State {
    _entities: Array<CategoriesTreeItem>
    _entity: Category|null
    _listItems: Array<CategoryListItem>
}

export const useCategoriesTreeStore = defineStore(storeName, {
    state: (): State => {
        return {
            _entities: [],
            _entity: null,
            _listItems: [],
        }
    },
    getters: {
        getCategoryAndSubtreeIds:
            (state) =>
            (id): Array<number> | null => {
                let categoryAndSubcategories = getCategoryAndSubcategoryCb(
                    state._entities,
                    id
                )

                if (!categoryAndSubcategories) {
                    return null
                }

                return getIdsCb([], categoryAndSubcategories)
            },
        categories: (state): Array<CategoriesTreeItem> => state._entities,
        category: (state): Category|null => state._entity,
        listItems: (state): Array<CategoryListItem> => state._listItems,
        options(): Array<Option> {
            const getReduceCB =
                (labelPrefix: string) =>
                (acc: Array<Option>, item: CategoriesTreeItem): Array<Option> => {
                    let option: Option = {
                        value: item.id,
                        label: `${labelPrefix}${item.name}`,
                    }
                    acc = [...acc, option]

                    acc = [
                        ...acc,
                        ...item.subcategories.reduce(
                            getReduceCB(`${labelPrefix}.`),
                            []
                        ),
                    ]

                    return acc
                }
            return this.categories.reduce(getReduceCB(""), [])
        },
        option() {
            return (id: string | number): Option | null => {
                let option = this.options.find(
                    (o: Option) => `${o.value}` === `${id}`
                )
                return option ? option : null
            }
        },
    },
    actions: {
        setEntities(entities: Array<CategoriesTreeItem>): void {
            this._entities = entities
        },
        setEntity(entity: Category|null) {
            this._entity = entity
        },
        setListItems(listItems: Array<CategoryListItem>): void {
            this._listItems = listItems
        }
    },
})

let getCategoryAndSubcategoryCb = (
    categories: Array<CategoriesTreeItem>,
    _id
): CategoriesTreeItem | null => {
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
    category: CategoriesTreeItem
): Array<number> => {
    acc = [...acc, category.id]
    for (let i = 0; i < category.subcategories.length; i++) {
        acc = getIdsCb(acc, category.subcategories[i])
    }
    return acc
}
