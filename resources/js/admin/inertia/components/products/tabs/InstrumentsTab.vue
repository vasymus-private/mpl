<script lang="ts" setup>
import ProductProduct from "@/admin/inertia/components/products/tabs/ProductProduct.vue"
import {ProductProductType} from "@/admin/inertia/modules/products/Product"
</script>

<template>
    <ProductProduct
        name="instruments"
        label="Инструменты"
        :type="ProductProductType.TYPE_INSTRUMENT"
        label-name="instruments_name"
    />
</template>
