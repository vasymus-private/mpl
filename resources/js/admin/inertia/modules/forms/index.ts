import { defineStore } from "pinia"
import {
    Char,
    CharCategory,
    Instruction,
    ProductForm,
} from "@/admin/inertia/modules/forms/ProductForm"
import Image from "@/admin/inertia/modules/common/Image"
import {
    isCreatingProductRoute,
    useProductsStore,
} from "@/admin/inertia/modules/products"
import { maxBy } from "lodash"
import {
    ProductProductType,
    SearchProduct,
    SearchProductRequest,
} from "@/admin/inertia/modules/products/Product"
import Meta from "@/admin/inertia/modules/common/Meta"

export const storeName = "forms"

export const useFormsStore = defineStore(storeName, {
    state: (): {
        _product: ProductForm
        _searchProduct: {
            [key in ProductProductType]: {
                entities: Array<SearchProduct>
                meta: Meta | null
                loading: boolean
            }
        }
    } => {
        return {
            _product: {},
            _searchProduct: {
                [ProductProductType.TYPE_ACCESSORY]: {
                    entities: [],
                    meta: null,
                    loading: false,
                },
                [ProductProductType.TYPE_SIMILAR]: {
                    entities: [],
                    meta: null,
                    loading: false,
                },
                [ProductProductType.TYPE_RELATED]: {
                    entities: [],
                    meta: null,
                    loading: false,
                },
                [ProductProductType.TYPE_WORK]: {
                    entities: [],
                    meta: null,
                    loading: false,
                },
                [ProductProductType.TYPE_INSTRUMENT]: {
                    entities: [],
                    meta: null,
                    loading: false,
                },
            },
        }
    },
    getters: {
        product: (state): ProductForm => state._product,
        maxInstructionsOrderColumn: function (): number | undefined {
            const max: Instruction | undefined = maxBy(
                this.product.instructions,
                (item: Instruction) => item.order_column
            )

            return (max && max.order_column) || undefined
        },
        maxAdditionalImagesOrderColumn: function (): number | undefined {
            const max: Image | undefined = maxBy(
                this.product.additionalImages,
                (item: Image) => item.order_column
            )

            return (max && max.order_column) || undefined
        },
        maxCharCategoriesOrdering: function (): number | undefined {
            const max: CharCategory | undefined = maxBy(
                this.product.charCategories,
                (item: CharCategory) => item.ordering
            )

            return (max && max.ordering) || undefined
        },
        maxCharsOrdering: function (): (a: string) => number | undefined {
            return (category_uuid: string): number | undefined => {
                const max: Char | undefined = maxBy(
                    this.product.chars.filter(
                        (item: Char) => item.category_uuid === category_uuid
                    ),
                    (item: Char) => item.ordering
                )

                return (max && max.ordering) || undefined
            }
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
        searchProducts:
            (state) =>
            (type: ProductProductType): Array<SearchProduct> =>
                state._searchProduct[type].entities,
        searchProductsLoading:
            (state) =>
            (type: ProductProductType): boolean =>
                state._searchProduct[type].loading,
    },
    actions: {
        setProductForm(product: ProductForm) {
            this._product = product
        },
        async fetchSearchProducts(
            request: SearchProductRequest,
            type: ProductProductType
        ): Promise<void> {
            const productsStore = useProductsStore()

            try {
                this._searchProduct[type].loading = true
                const { entities: products, meta } =
                    await productsStore.searchProducts(request)

                this._searchProduct[type].entities = products
                this._searchProduct[type].meta = meta
            } finally {
                this._searchProduct[type].loading = false
            }
        },
    },
})
