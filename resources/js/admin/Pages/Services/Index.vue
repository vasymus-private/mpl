<template>
    <div>
        <Head title="Услуги" />
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
        services: Array,
        auth: Object,
    },
    data() {
        return {

        }
    },
    created() {
        console.log('--- services', this.services)
        console.log('--- auth', this.auth)
    }
}
</script>
