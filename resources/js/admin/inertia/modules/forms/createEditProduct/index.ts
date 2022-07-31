import { defineStore } from "pinia"
import {
    isCreatingProductRoute,
    useProductsStore,
} from "@/admin/inertia/modules/products"
import Product, { Variation } from "@/admin/inertia/modules/products/Product"
import { AdminTab, TabEnum } from "@/admin/inertia/modules/common/Tabs"
import ElementsTab from "@/admin/inertia/components/products/createEdit/tabs/ElementsTab.vue"
import DescriptionTab from "@/admin/inertia/components/products/createEdit/tabs/DescriptionTab.vue"
import PhotoTab from "@/admin/inertia/components/products/createEdit/tabs/PhotoTab.vue"
import CharacteristicsTab from "@/admin/inertia/components/products/createEdit/tabs/CharacteristicsTab.vue"
import SeoTab from "@/admin/inertia/components/products/createEdit/tabs/SeoTab.vue"
import AccessoriesTab from "@/admin/inertia/components/products/createEdit/tabs/AccessoriesTab.vue"
import SimilarTab from "@/admin/inertia/components/products/createEdit/tabs/SimilarTab.vue"
import RelatedTab from "@/admin/inertia/components/products/createEdit/tabs/RelatedTab.vue"
import WorksTab from "@/admin/inertia/components/products/createEdit/tabs/WorksTab.vue"
import InstrumentsTab from "@/admin/inertia/components/products/createEdit/tabs/InstrumentsTab.vue"
import VariationsTab from "@/admin/inertia/components/products/createEdit/tabs/VariationsTab.vue"
import OtherTab from "@/admin/inertia/components/products/createEdit/tabs/OtherTab.vue"
import { randomId } from "@/admin/inertia/utils"
import * as yup from "yup"
import { CharTypeEnum } from "@/admin/inertia/modules/charTypes/CharType"
import { RouteParams, useRoutesStore } from "@/admin/inertia/modules/routes"

export const storeName = "forms"

interface State {
    _product: Partial<Product>
}

export const useCreateEditProductFormsStore = defineStore(storeName, {
    state: (): State => {
        return {
            _product: {},
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
        allAdminTabs: (): Array<AdminTab> => {
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
        adminTabs(state: State): Array<AdminTab> {
            if (state._product?.is_with_variations) {
                return this.allAdminTabs
            }

            return this.allAdminTabs.filter(
                (tab: AdminTab) => tab.value !== TabEnum.variations
            )
        },
        activeTab(): string {
            const routesStore = useRoutesStore()
            let url
            if (typeof window !== "undefined") {
                url = window.location.href
            }
            if (!url) {
                url = routesStore.fullUrl
            }
            if (!url) {
                return TabEnum.elements
            }
            let paramActiveTab = new URL(url).searchParams.get(
                RouteParams.activeTab
            )
            if (!paramActiveTab) {
                return TabEnum.elements
            }

            if (
                !this.adminTabs
                    .map((at) => at.value.toString())
                    .includes(paramActiveTab)
            ) {
                return TabEnum.elements
            }

            return paramActiveTab
        },
    },
    actions: {
        setProductForm(product: Partial<Product>) {
            this._product = product
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

export const getFormSchema = () => {
    return yup.object({
        id: yup.number().integer().truncate(),
        uuid: yup.string().nullable(),
        is_active: yup.boolean(),
        is_with_variations: yup.boolean(),
        name: yup.string().required().max(250),
        slug: yup.string().required().max(250),
        ordering: yup.number().truncate(),
        brand_id: yup.number().integer(),
        coefficient: yup.number().truncate(),
        coefficient_description: yup.string().max(250).nullable(),
        coefficient_description_show: yup.boolean(),
        coefficient_variation_description: yup.string().max(250).nullable(),
        price_name: yup.string().max(250).nullable(),
        infoPrices: yup
            .array()
            .of(
                yup.object({
                    id: yup.number().integer().truncate(),
                    name: yup.string().required().max(250),
                    price: yup.number().required().truncate(),
                })
            )
            .nullable(),
        admin_comment: yup.string().max(250).nullable(),
        instructions: yup.array().of(
            yup.object({
                id: yup.number().integer().truncate(),
                name: yup.string().required().max(250),
                file_name: yup.string().required().max(250),
                url: yup.string(),
                order_column: yup.number(),
                file: yup.mixed(),
            })
        ),
        price_purchase: yup.number(),
        price_purchase_currency_id: yup.number().integer(),
        price_retail: yup.number(),
        price_retail_currency_id: yup.number().integer(),
        unit: yup.string().max(250).nullable(),
        availability_status_id: yup.number().integer(),
        preview: yup.string().max(65000).nullable(),
        description: yup.string().max(65000).nullable(),
        mainImage: getImageSchema().nullable(),
        additionalImages: yup.array().of(getImageSchema()),
        charCategories: yup.array().of(
            yup.object({
                id: yup.number().integer().truncate(),
                uuid: yup.string().required(),
                name: yup.string().required().max(250),
                product_id: yup.number().integer().truncate(),
                ordering: yup.number(),
            })
        ),
        chars: yup.array().of(
            yup.object({
                id: yup.number().integer().truncate(),
                uuid: yup.string().required(),
                name: yup.string().required().max(250),
                value: yup.string().required().max(250),
                product_id: yup.number().integer().truncate(),
                type_id: yup.number().integer().truncate(),
                category_id: yup.number().integer().truncate(),
                category_uuid: yup.string().required(),
                ordering: yup.number(),
            })
        ),
        tempCharCategoryName: yup.string().max(250).nullable(),
        tempChar: yup
            .object({
                name: yup.string().max(250).nullable(),
                type_id: yup.number().integer().truncate(),
                category_uuid: yup.string().nullable(),
            })
            .nullable(),
        seo: yup
            .object({
                title: yup.string().max(250).nullable(),
                h1: yup.string().max(250).nullable(),
                keywords: yup.string().max(65000).nullable(),
                description: yup.string().max(65000).nullable(),
            })
            .nullable(),
        category_id: yup.number().integer().truncate(),
        relatedCategoriesIds: yup.array().of(yup.number().integer()),
        accessory_name: yup.string().max(250).nullable(),
        similar_name: yup.string().max(250).nullable(),
        related_name: yup.string().max(250).nullable(),
        work_name: yup.string().max(250).nullable(),
        instruments_name: yup.string().max(250).nullable(),
        accessories: yup
            .array()
            .of(
                yup.object({
                    id: yup.number().integer().required(),
                    uuid: yup.string().nullable(),
                    name: yup.string().nullable(),
                    image: yup.string().nullable(),
                    price_rub_formatted: yup.string().nullable(),
                })
            )
            .nullable(),
        similar: yup
            .array()
            .of(
                yup.object({
                    id: yup.number().integer().required(),
                    uuid: yup.string().nullable(),
                    name: yup.string().nullable(),
                    image: yup.string().nullable(),
                    price_rub_formatted: yup.string().nullable(),
                })
            )
            .nullable(),
        related: yup
            .array()
            .of(
                yup.object({
                    id: yup.number().integer().required(),
                    uuid: yup.string().nullable(),
                    name: yup.string().nullable(),
                    image: yup.string().nullable(),
                    price_rub_formatted: yup.string().nullable(),
                })
            )
            .nullable(),
        works: yup
            .array()
            .of(
                yup.object({
                    id: yup.number().integer().required(),
                    uuid: yup.string().nullable(),
                    name: yup.string().nullable(),
                    image: yup.string().nullable(),
                    price_rub_formatted: yup.string().nullable(),
                })
            )
            .nullable(),
        instruments: yup
            .array()
            .of(
                yup.object({
                    id: yup.number().integer().required(),
                    uuid: yup.string().nullable(),
                    name: yup.string().nullable(),
                    image: yup.string().nullable(),
                    price_rub_formatted: yup.string().nullable(),
                })
            )
            .nullable(),
        variations: yup.array().of(
            yup.object({
                id: yup.number().integer().truncate(),
                uuid: yup.string().nullable(),
                is_active: yup.boolean(),
                name: yup.string().required().max(250),
                ordering: yup.number().truncate(),
                coefficient: yup.number().truncate(),
                coefficient_description: yup.string().max(250).nullable(),
                price_purchase: yup.number().truncate(),
                price_purchase_currency_id: yup.number().integer().truncate(),
                price_retail: yup.number().truncate(),
                price_retail_currency_id: yup.number().integer().truncate(),
                unit: yup.string().max(250).nullable(),
                availability_status_id: yup.number().integer().truncate(),
                preview: yup.string().max(65000).nullable(),
                mainImage: getImageSchema().nullable(),
                additionalImages: yup.array().of(getImageSchema()),
                is_checked: yup.boolean(),
            })
        ),
    })
}

export const getImageSchema = () =>
    yup.object({
        id: yup.number().integer().truncate(),
        uuid: yup.string().nullable(),
        url: yup.string(),
        name: yup.string().max(250).nullable(),
        file_name: yup.string().max(250).nullable(),
        order_column: yup.number().nullable(),
        file: yup.mixed(),
    })

export const getWatchProductToFormCb =
    (setValues: (a: object) => any) => (product: Product | null) => {
        const {
            id,
            is_active,
            is_with_variations,
            name,
            slug,
            ordering,
            brand_id,
            coefficient,
            coefficient_description,
            coefficient_description_show,
            coefficient_variation_description,
            price_name,
            infoPrices = [],
            admin_comment,
            instructions = [],
            price_purchase,
            price_purchase_currency_id,
            price_retail,
            price_retail_currency_id,
            unit,
            availability_status_id,
            preview,
            description,
            mainImage,
            additionalImages = [],
            charCategories = [],
            seo,
            category_id,
            relatedCategoriesIds = [],
            accessory_name,
            similar_name,
            related_name,
            work_name,
            instruments_name,
            accessories = [],
            similar = [],
            related = [],
            works = [],
            instruments = [],
            variations = [],
        } = product || {}
        const _charCategories = charCategories.map(
            ({ id, name, product_id, ordering, chars }) => ({
                id,
                name,
                product_id,
                ordering,
                uuid: randomId(),
                chars,
            })
        )
        const chars = _charCategories.reduce((acc, { chars, uuid }) => {
            return [
                ...acc,
                ...chars.map((char) => ({
                    ...char,
                    uuid: randomId(),
                    category_uuid: uuid,
                    is_rate: char.type_id === CharTypeEnum.rate,
                })),
            ]
        }, [])
        setValues({
            id,
            is_active,
            is_with_variations,
            name,
            slug,
            ordering,
            brand_id,
            coefficient,
            coefficient_description,
            coefficient_description_show,
            coefficient_variation_description,
            price_name,
            infoPrices,
            admin_comment,
            instructions,
            price_purchase,
            price_purchase_currency_id,
            price_retail,
            price_retail_currency_id,
            unit,
            availability_status_id,
            preview,
            description,
            mainImage,
            additionalImages,
            charCategories: _charCategories,
            chars,
            seo,
            category_id,
            relatedCategoriesIds,
            accessory_name,
            similar_name,
            related_name,
            work_name,
            instruments_name,
            accessories,
            similar,
            related,
            works,
            instruments,
            variations,
        })
    }
