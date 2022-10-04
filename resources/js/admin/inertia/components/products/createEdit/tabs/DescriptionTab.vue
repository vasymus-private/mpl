<script lang="ts" setup>
import {computed} from "vue"
import {useProductsStore} from "@/admin/inertia/modules/products"
import {getRouteUrl, routeNames} from "@/admin/inertia/modules/routes"
import Description from "@/admin/inertia/components/forms/parts/Description.vue"


const productsStore = useProductsStore()

const uploadUrl = computed(() => {
    return productsStore.product?.id ? getRouteUrl(routeNames.ROUTE_ADMIN_AJAX_PRODUCT_IMAGE_UPLOAD, {admin_product: productsStore.product?.id}) : null
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
