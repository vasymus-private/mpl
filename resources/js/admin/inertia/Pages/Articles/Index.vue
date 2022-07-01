<script lang="ts" setup>
import { Head } from '@inertiajs/inertia-vue3'
import TheLayout from "@/admin/inertia/shared/layout/TheLayout.vue"
import {onMounted} from 'vue'
import {useArticlesStore} from "@/admin/inertia/modules/articles"


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
            <p>
                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    Button with data-bs-target
                </button>
            </p>
            <div class="collapse" id="collapseExample">
                <div class="card card-body">
                    Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.
                </div>
            </div>
        </div>
    </TheLayout>
</template>
