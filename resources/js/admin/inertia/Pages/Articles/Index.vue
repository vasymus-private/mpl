<script lang="ts" setup>
import { Head } from '@inertiajs/inertia-vue3'
import TheLayout from "@/admin/inertia/shared/layout/TheLayout.vue"
import {onMounted} from 'vue'
import {useArticlesStore} from "@/admin/inertia/store/articles"


const articlesStore = useArticlesStore();

onMounted(() => {
    console.log('--- articles', articlesStore.entities)
});

</script>

<template>
    <TheLayout>
        <div>
            <Head title="Статьи" />
            <h1>Статьи</h1>
        </div>
    </TheLayout>
</template>
