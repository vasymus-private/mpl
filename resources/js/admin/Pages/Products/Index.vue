<template>
    <div>
        <Head title="Товары" />
        <h1>Hello</h1>
    </div>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue'
import TheLayout from "@/admin/shared/layout/TheLayout";

export default {
    layout: TheLayout,
    components: {
        Head
    },
    props: {
        productsPaginated: Object,
        auth: Object,
    },
    data() {
        return {

        }
    },
    computed: {
        products() {
            return this.productsPaginated.data
        }
    },
    created() {
        console.log('--- productsPaginated', this.productsPaginated)
        console.log('--- auth', this.auth)
    }
}
</script>
