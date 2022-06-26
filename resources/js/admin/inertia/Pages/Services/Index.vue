<script lang="ts" setup>
import { Head } from '@inertiajs/inertia-vue3'
import TheLayout from "@/admin/inertia/shared/layout/TheLayout.vue";
import {onMounted} from 'vue'
import {useServicesStore} from "@/admin/inertia/store/services";


const servicesStore = useServicesStore()

onMounted(() => {
    console.log('--- services', servicesStore.entities)
})

</script>

<template>
    <TheLayout>
        <div>
            <Head title="Услуги" />
            <h1>Услуги</h1>
        </div>
    </TheLayout>
</template>
