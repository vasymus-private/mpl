<script lang="ts" setup>
import ProductProduct from "@/admin/inertia/components/products/tabs/ProductProduct.vue"
import {ProductProductType} from "@/admin/inertia/modules/products/Product"
</script>

<template>
    <ProductProduct
        name="related"
        label="Сопряженные"
        :type="ProductProductType.TYPE_RELATED"
        label-name="related_name"
    />
</template>
