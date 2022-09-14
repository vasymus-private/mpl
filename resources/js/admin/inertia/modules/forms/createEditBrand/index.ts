import { defineStore } from "pinia"
import { useBrandsStore } from "@/admin/inertia/modules/brands"
import { AdminTab, TabEnum } from "@/admin/inertia/modules/common/Tabs"
import ElementsTab from "@/admin/inertia/components/brands/createEdit/tabs/ElementsTab.vue"
import DescriptionTab from "@/admin/inertia/components/brands/createEdit/tabs/DescriptionTab.vue"
import PhotoTab from "@/admin/inertia/components/brands/createEdit/tabs/PhotoTab.vue"
import SeoTab from "@/admin/inertia/components/brands/createEdit/tabs/SeoTab.vue"

export const storeName = "createEditBrandForm"

export const useCreateEditBrandFormStore = defineStore(storeName, {
    getters: {
        brandFormTitle: (): string => {
            let base = "Справочники: производители: "
            const brandsStore = useBrandsStore()

            base += brandsStore.isCreatingBrandRoute
                ? "добавление"
                : `${brandsStore.brand?.name} - редактирование`

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
                    value: TabEnum.seo,
                    label: "SEO",
                    is: SeoTab,
                },
            ]
        },
    },
})
