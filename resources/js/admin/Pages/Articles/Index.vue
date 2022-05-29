<template>
    <div>
        <Head title="Articles" />
        <h1>Hello</h1>
    </div>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue'

export default {
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
