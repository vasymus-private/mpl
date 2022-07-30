<script lang="ts" setup>
import ProductProduct from "@/admin/inertia/components/products/createEdit/tabs/ProductProduct.vue"
import {ProductProductType} from "@/admin/inertia/modules/products/Product"
</script>

<template>
    <ProductProduct
        name="accessories"
        label="Аксессуары"
        :type="ProductProductType.TYPE_ACCESSORY"
        label-name="accessory_name"
    />
</template>
