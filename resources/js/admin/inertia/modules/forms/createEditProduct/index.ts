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
import {
    randomId,
    yupNumberOrEmptyString,
    yupIntegerOrEmptyString,
} from "@/admin/inertia/utils"
import * as yup from "yup"
import { CharTypeEnum } from "@/admin/inertia/modules/charTypes/CharType"
import { RouteParams, useRoutesStore } from "@/admin/inertia/modules/routes"
import {Values} from "@/admin/inertia/modules/forms/createEditProduct/types"

export const storeName = "createEditForm"

interface State {
    _product: Partial<Product>
}

export const useCreateEditProductFormStore = defineStore(storeName, {
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
        async submitCreateEditProduct(values: Values, { setErrors }) {

        }
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

/**
 * @see Values
 */
export const getFormSchema = () => {
    return yup.object({
        id: yupIntegerOrEmptyString(),
        uuid: yup.string().nullable(),
        name: yup.string().required().max(250),
        slug: yup.string().required().max(250),
        ordering: yupIntegerOrEmptyString(),
        is_active: yup.boolean(),
        unit: yup.string().max(250).nullable(),
        price_purchase: yupNumberOrEmptyString(),
        price_purchase_currency_id: yupIntegerOrEmptyString(),
        price_retail: yupNumberOrEmptyString(),
        price_retail_currency_id: yupIntegerOrEmptyString(),
        admin_comment: yup.string().max(250).nullable(),
        availability_status_id: yupIntegerOrEmptyString(),
        brand_id: yupIntegerOrEmptyString(),
        category_id: yupIntegerOrEmptyString(),
        relatedCategoriesIds: yup.array().of(yup.number().integer()).nullable(),
        is_with_variations: yup.boolean(),
        coefficient: yupNumberOrEmptyString(),
        coefficient_description: yup.string().max(250).nullable(),
        coefficient_description_show: yup.boolean(),
        coefficient_variation_description: yup.string().max(250).nullable(),
        price_name: yup.string().max(250).nullable(),
        preview: yup.string().max(65000).nullable(),
        description: yup.string().max(65000).nullable(),
        accessory_name: yup.string().max(250).nullable(),
        similar_name: yup.string().max(250).nullable(),
        related_name: yup.string().max(250).nullable(),
        work_name: yup.string().max(250).nullable(),
        instruments_name: yup.string().max(250).nullable(),
        seo: yup
            .object({
                title: yup.string().max(250).nullable(),
                h1: yup.string().max(250).nullable(),
                keywords: yup.string().max(65000).nullable(),
                description: yup.string().max(65000).nullable(),
            })
            .nullable(),
        infoPrices: yup.array().of(getInfoPriceSchema()).nullable(),
        instructions: yup.array().of(getInstructionSchema()).nullable(),
        mainImage: getImageSchema().nullable(),
        additionalImages: yup.array().of(getImageSchema()).nullable(),
        charCategories: yup.array().of(getCharCategorySchema()).nullable(),
        accessories: yup.array().of(getProductProductSchema()).nullable(),
        similar: yup.array().of(getProductProductSchema()).nullable(),
        related: yup.array().of(getProductProductSchema()).nullable(),
        works: yup.array().of(getProductProductSchema()).nullable(),
        instruments: yup.array().of(getProductProductSchema()).nullable(),
        variations: yup.array().of(getVariationSchema()).nullable(),
        chars: yup.array().of(getCharSchema()).nullable(),
        tempCharCategoryName: yup.string().max(250).nullable(),
        tempChar: yup
            .object({
                name: yup.string().max(250).nullable(),
                type_id: yupIntegerOrEmptyString(),
                category_uuid: yup.string().nullable(),
            })
            .nullable(),
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

export const getProductProductSchema = () =>
    yup.object({
        id: yup.number().integer().required(),
        uuid: yup.string().nullable(),
        name: yup.string().nullable(),
        image: yup.string().nullable(),
        price_rub_formatted: yup.string().nullable(),
    })

export const getInfoPriceSchema = () =>
    yup.object({
        id: yupIntegerOrEmptyString(),
        name: yup.string().required().max(250),
        price: yupNumberOrEmptyString(),
    })

export const getInstructionSchema = () =>
    yup.object({
        id: yupIntegerOrEmptyString(),
        name: yup.string().required().max(250),
        file_name: yup.string().required().max(250),
        url: yup.string(),
        order_column: yupIntegerOrEmptyString(),
        file: yup.mixed(),
    })

export const getVariationSchema = () =>
    yup.object({
        id: yupIntegerOrEmptyString(),
        uuid: yup.string().nullable(),
        is_active: yup.boolean(),
        name: yup.string().required().max(250),
        ordering: yupIntegerOrEmptyString(),
        coefficient: yupNumberOrEmptyString(),
        coefficient_description: yup.string().max(250).nullable(),
        price_purchase: yupNumberOrEmptyString(),
        price_purchase_currency_id: yupIntegerOrEmptyString(),
        price_retail: yupNumberOrEmptyString(),
        price_retail_currency_id: yupIntegerOrEmptyString(),
        unit: yup.string().max(250).nullable(),
        availability_status_id: yupIntegerOrEmptyString(),
        preview: yup.string().max(65000).nullable(),
        mainImage: getImageSchema().nullable(),
        additionalImages: yup.array().of(getImageSchema()),
        is_checked: yup.boolean(),
    })

export const getCharCategorySchema = () =>
    yup.object({
        id: yupIntegerOrEmptyString(),
        uuid: yup.string().required(),
        name: yup.string().required().max(250),
        product_id: yup.number().integer().truncate(),
        ordering: yupIntegerOrEmptyString(),
    })

export const getCharSchema = () =>
    yup.object({
        id: yupIntegerOrEmptyString(),
        uuid: yup.string().required(),
        name: yup.string().required().max(250),
        value: yup.string().required().max(250),
        product_id: yupIntegerOrEmptyString(),
        type_id: yup.number().integer().truncate(),
        category_id: yupIntegerOrEmptyString(),
        category_uuid: yup.string().required(),
        ordering: yupIntegerOrEmptyString(),
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
