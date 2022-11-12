<script lang="ts" setup>
import {useCategoriesStore} from "@/admin/inertia/modules/categories"
import ProductCategories from '@/admin/inertia/components/products/forms/ProductCategories.vue'


const categoriesStore = useCategoriesStore()
</script>

<template>
    <div class="item-edit product-edit other-page">
        <div class="row-line">
            <div class="column">
                <span class="other-page__title">Разделы:</span>
            </div>
            <ProductCategories />
        </div>
    </div>
</template>
