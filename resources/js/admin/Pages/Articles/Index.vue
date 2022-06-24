<template>
    <div>
        <Head title="Статьи" />
        <h1>Hello</h1>
    </div>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue3'
import TheLayout from "@/admin/shared/layout/TheLayout";

export default {
    layout: TheLayout,
    components: {
        Head
    },
    props: {
        articles: Array,
        auth: Object,
    },
    data() {
        return {

        }
    },
    created() {
        console.log('--- articles', this.articles)
        console.log('--- auth', this.auth)
    }
}
</script>
