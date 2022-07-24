import { defineStore } from "pinia"
import {
    AdditionalImage,
    Instruction,
    ProductForm,
} from "@/admin/inertia/modules/forms/ProductForm"
import {
    isCreatingProductRoute,
    useProductsStore,
} from "@/admin/inertia/modules/products"
import { maxBy } from "lodash"

export const storeName = "forms"

export const useFormsStore = defineStore(storeName, {
    state: (): { _product: ProductForm } => {
        return {
            _product: {},
        }
    },
    getters: {
        product: (state): ProductForm => state._product,
        maxInstructionsColumn: function (): number | undefined {
            const maxInstructionByColumn: Instruction | undefined = maxBy(
                this.product.instructions,
                (item: Instruction) => item.order_column
            )

            return (
                (maxInstructionByColumn &&
                    maxInstructionByColumn.order_column) ||
                undefined
            )
        },
        maxAdditionalImagesColumn: function (): number | undefined {
            const maxAdditionalByColumn: AdditionalImage | undefined = maxBy(
                this.product.additionalImages,
                (item: AdditionalImage) => item.order_column
            )

            return (
                (maxAdditionalByColumn && maxAdditionalByColumn.order_column) ||
                undefined
            )
        },
        productFormTitle: (): string => {
            let base = "Товары: элемент: "
            const productsStore = useProductsStore()
            const isCreating = isCreatingProductRoute()

            base += productsStore.isCreatingFromCopy
                ? "добавление копированием"
                : isCreating
                ? "добавление"
                : `${productsStore.product?.name} - редактирование`

            return base
        },
    },
    actions: {
        setProductForm(product: ProductForm) {
            this._product = product
        },
    },
})
