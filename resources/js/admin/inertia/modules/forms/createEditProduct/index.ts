import { defineStore } from "pinia"
import {
    isCreatingProductRoute,
    useProductsStore,
} from "@/admin/inertia/modules/products"
import Product, {
    ProductProductType,
    SearchProduct,
    SearchProductRequest,
    Variation,
} from "@/admin/inertia/modules/products/Product"
import Meta from "@/admin/inertia/modules/common/Meta"
import { AdminTab, TabEnum } from "@/admin/inertia/modules/common/Tabs"
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
import { randomId } from "@/admin/inertia/utils"

export const storeName = "forms"

interface State {
    _product: Partial<Product>
    _searchProduct: {
        [key in ProductProductType]: {
            entities: Array<SearchProduct>
            meta: Meta | null
            loading: boolean
        }
    }
}

export const useCreateEditProductFormsStore = defineStore(storeName, {
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
        product: (state: State): Partial<Product> => state._product,
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
        setProductForm(product: Partial<Product>) {
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

export const getEmptyVariation = (): Variation => ({
    id: null,
    uuid: randomId(),
    is_active: false,
    name: "",
    ordering: 500,
    coefficient: null,
    coefficient_description: null,
    price_purchase: null,
    price_purchase_currency_id: null,
    price_retail: null,
    price_retail_currency_id: null,
    unit: null,
    availability_status_id: null,
    preview: null,
    mainImage: null,
    additionalImages: [],
})
