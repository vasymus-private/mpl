<script lang="ts" setup>
import { Head } from '@inertiajs/inertia-vue3'
import TheLayout from "@/admin/inertia/shared/layout/TheLayout.vue";
import {onMounted} from 'vue'
import Article from "../../entities/Article";
import Auth from "../../entities/Auth";


const props = defineProps<{
    auth: Auth,
    articles: Array<Article>
}>()

onMounted(() => {
    console.log('--- articles', props.articles)
    console.log('--- auth', props.auth)
    console.log('--- temp')
})
</script>

<template>
    <TheLayout>
        <div>
            <Head title="Статьи" />
            <h1>Статьи</h1>
        </div>
    </TheLayout>
</template>
