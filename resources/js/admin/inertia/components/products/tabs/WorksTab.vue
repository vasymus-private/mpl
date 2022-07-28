<script lang="ts" setup>
import ProductProduct from "@/admin/inertia/components/products/tabs/ProductProduct.vue"
import {ProductProductType} from "@/admin/inertia/modules/products/Product"
</script>

<template>
    <ProductProduct
        name="works"
        label="Работы"
        :type="ProductProductType.TYPE_WORK"
        label-name="work_name"
    />
</template>
