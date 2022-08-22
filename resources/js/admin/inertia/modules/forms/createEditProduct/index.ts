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
import {getRouteUrl, routeNames, RouteParams, useRoutesStore} from "@/admin/inertia/modules/routes"
import { Values } from "@/admin/inertia/modules/forms/createEditProduct/types"
import axios, {AxiosError} from "axios";
import {ErrorResponse} from "@/admin/inertia/modules/forms/indexProducts/types";
import {getIndexForIdCb} from "@/admin/inertia/modules/forms/indexProducts";
import {Errors} from "@/admin/inertia/modules/common/types";
import {CustomFormData} from "@/admin/inertia/utils/CustomFormData";

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
        async submitCreateEditProduct(values: Values, { setErrors }): Promise<void> {
            const isCreating = isCreatingProductRoute()

            try {
                let product: Product

                const formData = valuesToFormData(values)

                if (isCreating) {
                    const response = await axios.post<{data: Product}>(
                        getRouteUrl(
                            routeNames.ROUTE_ADMIN_AJAX_PRODUCTS_STORE
                        ),
                        formData,
                        {
                            headers: { "Content-Type": "multipart/form-data" }
                        }
                    )
                    product = response.data.data
                }
                if (!isCreating) {
                    formData.append('_method', 'PUT')
                    const response = await axios.post<{data: Product}>(
                        getRouteUrl(
                            routeNames.ROUTE_ADMIN_AJAX_PRODUCTS_UPDATE,
                            values.id
                        ),
                        formData,
                        {
                            headers: { "Content-Type": "multipart/form-data" }
                        }
                    )
                    product = response.data.data
                }

                const productsStore = useProductsStore()
                productsStore.setProduct(product)
            } catch (e) {
                if (e instanceof AxiosError) {

                    const {
                        data: { errors },
                    }: ErrorResponse = e.response

                    const errorFields = errorsToErrorFields(errors)

                    setErrors(errorFields)
                    return
                }
                throw e
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

const errorsToErrorFields = (errors: Errors): Record<string, string | undefined> => {
    let errorFields = {}

    for (let key in errors) {
        errorFields = {
            ...errorFields,
            [key]: errors[key].join(' ')
        }
    }

    return errorFields
}

const valuesToFormData = (values: Values): FormData => {
    const formData = new CustomFormData()

    let keys: Array<keyof Values> = ['name', 'slug', 'ordering', 'unit', 'price_purchase', 'price_purchase_currency_id', 'price_retail', 'price_retail_currency_id', 'admin_comment', 'availability_status_id', 'brand_id', 'category_id', 'coefficient', 'coefficient_description', 'coefficient_description_show', 'coefficient_variation_description', 'price_name', 'preview', 'description', 'accessory_name', 'similar_name', 'related_name', 'work_name', 'instruments_name']

    keys.forEach(key => {
        formData.set(key, values[key] ? `${values[key]}` : '')
    })

    if (values.is_active != null) {
        formData.set('is_active', `${+values.is_active}`)
    }

    values.relatedCategoriesIds.forEach(id => formData.append('relatedCategoriesIds', `${id}`))

    if (values.is_with_variations != null) {
        formData.set('is_with_variations', `${+values.is_with_variations}`)
    }

    if (values.seo) {
        formData.append('seo[title]', `${values.seo.title}`)
        formData.append('seo[h1]', `${values.seo.h1}`)
        formData.append('seo[keywords]', `${values.seo.keywords}`)
        formData.append('seo[description]', `${values.seo.description}`)
    }

    values.infoPrices.forEach((infoPrice, index) => {
        formData.append(`infoPrices[${index}][id]`, infoPrice.id ? `${infoPrice.id}` : '')
        formData.append(`infoPrices[${index}][name]`, `${infoPrice.name}`)
        formData.append(`infoPrices[${index}][price]`, `${infoPrice.price}`)
    })

    values.instructions.forEach((instruction, index) => {
        formData.append(`instructions[${index}][id]`, instruction.id ? `${instruction.id}` : '')
        formData.append(`instructions[${index}][uuid]`, `${instruction.uuid}`)
        formData.append(`instructions[${index}][name]`, `${instruction.name}`)
        formData.append(`instructions[${index}][file_name]`, `${instruction.file_name}`)
        formData.append(`instructions[${index}][order_column]`, `${instruction.order_column}`)

        if (instruction.file) {
            formData.append(`instructions[${index}][file]`, instruction.file)
        }
    })

    if (values.mainImage) {
        formData.append(`mainImage[id]`, values.mainImage.id ? `${values.mainImage.id}` : '')
        formData.append(`mainImage[uuid]`, `${values.mainImage.uuid}`)
        formData.append(`mainImage[name]`, `${values.mainImage.name}`)
        formData.append(`mainImage[file_name]`, `${values.mainImage.file_name}`)
        formData.append(`mainImage[order_column]`, `${values.mainImage.order_column}`)

        if (values.mainImage.file) {
            formData.append(`mainImage[file]`, values.mainImage.file)
        }
    }

    values.additionalImages.forEach((image, index) => {
        formData.append(`additionalImages[${index}][id]`, image.id ? `${image.id}` : '')
        formData.append(`additionalImages[${index}][uuid]`, image.uuid ? `${image.uuid}` : '')
        formData.append(`additionalImages[${index}][name]`, image.name ? `${image.name}` : '')
        formData.append(`additionalImages[${index}][file_name]`, image.file_name ? `${image.file_name}` : '')
        formData.append(`additionalImages[${index}][order_column]`, image.order_column ? `${image.order_column}` : '')

        if (image.file) {
            formData.append(`additionalImages[${index}][file]`, image.file)
        }
    })

    values.charCategories.forEach((charCategory, index) => {
        formData.append(`charCategories[${index}][id]`, charCategory.id ? `${charCategory.id}` : '')
        formData.append(`charCategories[${index}][uuid]`, charCategory.uuid ? `${charCategory.uuid}` : '')
        formData.append(`charCategories[${index}][name]`, charCategory.name ? `${charCategory.name}` : '')
        formData.append(`charCategories[${index}][ordering]`, charCategory.ordering ? `${charCategory.ordering}` : '')
    })

    values.chars.forEach((char, index) => {
        formData.append(`chars[${index}][id]`, char.id ? `${char.id}` : '')
        formData.append(`chars[${index}][name]`, char.name ? `${char.name}` : '')
        formData.append(`chars[${index}][value]`, char.value ? `${char.value}` : '')
        formData.append(`chars[${index}][type_id]`, char.type_id ? `${char.type_id}` : '')
        formData.append(`chars[${index}][ordering]`, char.ordering ? `${char.ordering}` : '')
        formData.append(`chars[${index}][category_id]`, char.category_id ? `${char.category_id}` : '')
        formData.append(`chars[${index}][category_uuid]`, char.category_uuid ? `${char.category_uuid}` : '')
    })

    values.accessories.forEach(otherProduct => {
        formData.append(`accessories[]`, `${otherProduct.id}`)
    })

    values.similar.forEach(otherProduct => {
        formData.append(`similar[]`, `${otherProduct.id}`)
    })

    values.related.forEach(otherProduct => {
        formData.append(`related[]`, `${otherProduct.id}`)
    })

    values.works.forEach(otherProduct => {
        formData.append(`works[]`, `${otherProduct.id}`)
    })

    values.instruments.forEach(otherProduct => {
        formData.append(`instruments[]`, `${otherProduct.id}`)
    })

    values.variations.forEach((variation, index) => {
        formData.append(`variations[${index}][id]`, variation.id ? `${variation.id}` : '')
        formData.append(`variations[${index}][uuid]`, variation.uuid ? `${variation.uuid}` : '')
        formData.append(`variations[${index}][name]`, variation.name ? `${variation.name}` : '')

        if (variation.is_active != null) {
            formData.set(`variations[${index}][is_active]`, `${+variation.is_active}`)
        }

        formData.append(`variations[${index}][ordering]`, variation.ordering ? `${variation.ordering}` : '')
        formData.append(`variations[${index}][coefficient]`, variation.coefficient ? `${variation.coefficient}` : '')
        formData.append(`variations[${index}][coefficient_description]`, variation.coefficient_description ? `${variation.coefficient_description}` : '')
        formData.append(`variations[${index}][unit]`, variation.unit ? `${variation.unit}` : '')
        formData.append(`variations[${index}][availability_status_id]`, variation.availability_status_id ? `${variation.availability_status_id}` : '')
        formData.append(`variations[${index}][price_purchase]`, variation.price_purchase ? `${variation.price_purchase}` : '')
        formData.append(`variations[${index}][price_purchase_currency_id]`, variation.price_purchase_currency_id ? `${variation.price_purchase_currency_id}` : '')
        formData.append(`variations[${index}][price_retail]`, variation.price_retail ? `${variation.price_retail}` : '')
        formData.append(`variations[${index}][price_retail_currency_id]`, variation.price_retail_currency_id ? `${variation.price_retail_currency_id}` : '')
        formData.append(`variations[${index}][preview]`, variation.preview ? `${variation.preview}` : '')

        if (variation.mainImage) {
            formData.append(`variations[${index}][mainImage][id]`, variation.mainImage.id ? `${variation.mainImage.id}` : '')
            formData.append(`variations[${index}][mainImage][uuid]`, variation.mainImage.uuid ? `${variation.mainImage.uuid}` : '')
            formData.append(`variations[${index}][mainImage][name]`, variation.mainImage.name ? `${variation.mainImage.name}` : '')
            formData.append(`variations[${index}][mainImage][file_name]`, variation.mainImage.file_name ? `${variation.mainImage.file_name}` : '')
            formData.append(`variations[${index}][mainImage][order_column]`, variation.mainImage.order_column ? `${variation.mainImage.order_column}` : '')

            if (variation.mainImage.file) {
                formData.append(`variations[${index}][mainImage][file]`, variation.mainImage.file)
            }
        }

        variation.additionalImages.forEach((image, i) => {
            formData.append(`variations[${index}][additionalImages][${i}][id]`, image.id ? `${image.id}` : '')
            formData.append(`variations[${index}][additionalImages][${i}][uuid]`, image.uuid ? `${image.uuid}` : '')
            formData.append(`variations[${index}][additionalImages][${i}][name]`, image.name ? `${image.name}` : '')
            formData.append(`variations[${index}][additionalImages][${i}][file_name]`, image.file_name ? `${image.file_name}` : '')
            formData.append(`variations[${index}][additionalImages][${i}][order_column]`, image.order_column ? `${image.order_column}` : '')

            if (image.file) {
                formData.append(`variations[${index}][additionalImages][${i}][file]`, image.file)
            }
        })
    })

    return formData
}
