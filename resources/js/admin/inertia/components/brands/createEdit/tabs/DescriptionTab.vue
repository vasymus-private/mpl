<script lang="ts" setup>
import {computed} from "vue"
import {routeNames, useRoutesStore} from "@/admin/inertia/modules/routes"
import Description from "@/admin/inertia/components/forms/parts/Description.vue"
import {useBrandsStore} from "@/admin/inertia/modules/brands"


const brandsStore = useBrandsStore()
const routesStore = useRoutesStore()

const uploadUrl = computed(() => {
    return brandsStore.brand?.id
        ? routesStore.route(routeNames.ROUTE_ADMIN_AJAX_PRODUCT_IMAGE_UPLOAD, {admin_product: brandsStore.brand.id})
        : null
})
</script>

<template>
    <div class="item-edit product-edit">
        <Description
            id="preview"
            label="Описание для анонса"
            name="preview"
            :upload-url="uploadUrl"
        />

        <Description
            id="description"
            label="Детальное описание"
            name="description"
            :upload-url="uploadUrl"
        />
    </div>
</template>
