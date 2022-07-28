<script lang="ts" setup>
import ProductProduct from "@/admin/inertia/components/products/tabs/ProductProduct.vue"
import {ProductProductType} from "@/admin/inertia/modules/products/Product"
</script>

<template>
    <ProductProduct
        name="similar"
        label="Похожие"
        :type="ProductProductType.TYPE_SIMILAR"
        label-name="similar_name"
    />
</template>
