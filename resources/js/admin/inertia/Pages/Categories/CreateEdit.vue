<script setup lang="ts">
import TheLayout from '@/admin/inertia/components/layout/TheLayout.vue'
import Breadcrumbs from '@/admin/inertia/components/categories/createEdit/parts/Breadcrumbs.vue'
import Toolbar from '@/admin/inertia/components/categories/createEdit/parts/Toolbar.vue'
import {useCreateEditCategoryFormStore} from "@/admin/inertia/modules/forms/createEditCategory"


const createEditCategoryFormStore = useCreateEditCategoryFormStore()
</script>

<template>
    <TheLayout>
        <div>
            <Breadcrumbs />

            <h1 class="h2 adm-title">
                {{ createEditCategoryFormStore.categoryFormTitle }}
            </h1>

            <Toolbar />
        </div>
    </TheLayout>
</template>
