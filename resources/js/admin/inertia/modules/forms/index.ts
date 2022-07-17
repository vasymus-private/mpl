import { defineStore } from "pinia"
import {ProductForm} from "@/admin/inertia/modules/forms/ProductForm";
import {isCreatingProductRoute, useProductsStore} from "@/admin/inertia/modules/products";


export const storeName = "forms"

export const useFormsStore = defineStore(storeName, {
    state: (): {_product: ProductForm} => {
        return {
            _product: {}
        }
    },
    getters: {
        product: (state): ProductForm => state._product,
        productFormTitle: (): string => {
            let base = 'Товары: элемент: '
            const productsStore = useProductsStore()
            const isCreating = isCreatingProductRoute()

            base += (
                productsStore.isCreatingFromCopy
                    ? 'добавление копированием'
                    : (isCreating
                        ? 'добавление'
                        : `${productsStore.product?.name} - редактирование`)
            )

            return base
        }
    },
    actions: {
        setProductForm(product: ProductForm) {
            this._product = product
        },
    }
})
