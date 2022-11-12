<script lang="ts" setup>
import ProductProduct from "@/admin/inertia/components/products/createEdit/tabs/ProductProduct.vue"
import {ProductProductType} from "@/admin/inertia/modules/products/types"
</script>

<template>
    <ProductProduct
        name="instruments"
        label="Инструменты"
        :type="ProductProductType.TYPE_INSTRUMENT"
        label-name="instruments_name"
    />
</template>
