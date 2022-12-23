<script lang="ts" setup>
import { Head } from '@inertiajs/inertia-vue3'
import TheLayout from "@/admin/inertia/components/layout/TheLayout.vue"
import {onMounted} from 'vue'


onMounted(() => {
    console.log('--- ttt')
});

</script>

<template>
    <TheLayout>
        <div>
            <Head title="Временно" />
            <h1>Временно</h1>
        </div>
    </TheLayout>
</template>
