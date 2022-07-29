import { defineStore } from "pinia"
import {
    Char,
    CharCategory,
    Instruction,
    ProductForm,
} from "@/admin/inertia/modules/forms/ProductForm"
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
import {AdminTab, TabEnum} from "@/admin/inertia/modules/forms/Tabs"
import ElementsTab from "@/admin/inertia/components/products/tabs/ElementsTab.vue"
import DescriptionTab from "@/admin/inertia/components/products/tabs/DescriptionTab.vue"
import PhotoTab from "@/admin/inertia/components/products/tabs/PhotoTab.vue"
import CharacteristicsTab from "@/admin/inertia/components/products/tabs/CharacteristicsTab.vue"
import SeoTab from "@/admin/inertia/components/products/tabs/SeoTab.vue"
import AccessoriesTab from "@/admin/inertia/components/products/tabs/AccessoriesTab.vue"
import SimilarTab from "@/admin/inertia/components/products/tabs/SimilarTab.vue"
import RelatedTab from "@/admin/inertia/components/products/tabs/RelatedTab.vue"
import WorksTab from "@/admin/inertia/components/products/tabs/WorksTab.vue"
import InstrumentsTab from "@/admin/inertia/components/products/tabs/InstrumentsTab.vue"
import VariationsTab from "@/admin/inertia/components/products/tabs/VariationsTab.vue"
import OtherTab from "@/admin/inertia/components/products/tabs/OtherTab.vue"

export const storeName = "forms"

interface State {
    _product: ProductForm
    _searchProduct: {
        [key in ProductProductType]: {
            entities: Array<SearchProduct>
            meta: Meta | null
            loading: boolean
        }
    }
}

export const useFormsStore = defineStore(storeName, {
    state: (): State => {
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
        product: (state: State): ProductForm => state._product,
        maxInstructionsOrderColumn: function (): number | undefined {
            const max: Instruction | undefined = maxBy(
                this.product.instructions,
                (item: Instruction) => item.order_column
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
            (state: State) =>
            (type: ProductProductType): Array<SearchProduct> =>
                state._searchProduct[type].entities,
        searchProductsLoading:
            (state: State) =>
            (type: ProductProductType): boolean =>
                state._searchProduct[type].loading,
        getAllAdminTabs: (): Array<AdminTab> => {
            return [
                {
                    value: TabEnum.elements,
                    label: "Элемент",
                    is: ElementsTab,
                },
                {
                    value: TabEnum.description,
                    label: "Описание",
                    is: DescriptionTab,
                },
                {
                    value: TabEnum.photo,
                    label: "Фото",
                    is: PhotoTab,
                },
                {
                    value: TabEnum.characteristics,
                    label: "Характеристики",
                    is: CharacteristicsTab,
                },
                {
                    value: TabEnum.seo,
                    label: "SEO",
                    is: SeoTab,
                },
                {
                    value: TabEnum.accessories,
                    label: "Аксессуары",
                    is: AccessoriesTab,
                },
                {
                    value: TabEnum.similar,
                    label: "Похожие",
                    is: SimilarTab,
                },
                {
                    value: TabEnum.related,
                    label: "Сопряжённые",
                    is: RelatedTab,
                },
                {
                    value: TabEnum.works,
                    label: "Работы",
                    is: WorksTab,
                },
                {
                    value: TabEnum.instruments,
                    label: "Инструменты",
                    is: InstrumentsTab,
                },
                {
                    value: TabEnum.variations,
                    label: "Варианты",
                    is: VariationsTab,
                },
                {
                    value: TabEnum.other,
                    label: "Прочее",
                    is: OtherTab,
                },
            ]
        },
        getAdminTabs(state: State): Array<AdminTab> {
            if (state._product?.is_with_variations) {
                return this.getAllAdminTabs
            }

            return this.getAllAdminTabs.filter(
                (tab: AdminTab) => tab.value !== TabEnum.variations
            )
        },
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
