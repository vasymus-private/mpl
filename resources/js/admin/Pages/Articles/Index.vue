<script lang="ts" setup>
import { Head } from '@inertiajs/inertia-vue3'
import TheLayout from '../../shared/layout/TheLayout.vue'
import {ref, onMounted} from 'vue'
import Article from "../../entities/Article";
import Auth from "../../entities/Auth";

const count = ref(0)

function increment() {
    count.value++
}

const props = defineProps<{
    auth: Auth,
    articles: Array<Article>
}>()

onMounted(() => {
    console.log('--- articles', props.articles)
    console.log('--- auth', props.auth)
})

</script>

<template>
    <TheLayout>
        <div>
            <Head title="Статьи" />
            <h1>Hello</h1>
        </div>
    </TheLayout>
</template>
