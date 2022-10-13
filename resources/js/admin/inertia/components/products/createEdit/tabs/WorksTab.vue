<script lang="ts" setup>
import ProductProduct from "@/admin/inertia/components/products/createEdit/tabs/ProductProduct.vue"
import {ProductProductType} from "@/admin/inertia/modules/products/types"
</script>

<template>
    <ProductProduct
        name="works"
        label="Работы"
        :type="ProductProductType.TYPE_WORK"
        label-name="work_name"
    />
</template>
