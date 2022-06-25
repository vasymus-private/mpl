<script lang="ts" setup>
import { Head } from '@inertiajs/inertia-vue3'
import TheLayout from "@/admin/inertia/shared/layout/TheLayout.vue";
import {onMounted} from 'vue'
import {Service} from "@/admin/inertia/entities/Service";


const props = defineProps<{
    services: Array<Service>
}>()

onMounted(() => {
    console.log('--- services', props.services)
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
