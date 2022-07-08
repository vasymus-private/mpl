<script lang="ts" setup>
import TheHeader from "@/admin/inertia/shared/layout/TheHeader.vue"
import TheSidebar from "@/admin/inertia/shared/layout/TheSidebar.vue"
import {useModalsStore, Modals} from "@/admin/inertia/modules/modals"


const modalsStore = useModalsStore()
</script>

<template>
    <div id="wrapper" class="wrapper">
        <TheHeader />
        <main class="d-flex">
            <div id="resize-container" class="">
                <TheSidebar />
                <div id="resizer"></div>
                <div class="" id="content">
                    <slot></slot>
                </div>
            </div>
        </main>
        <component
            v-for="modal in modalsStore.types"
            :is="Modals[modal.type]"
            :type="modal.type"
        />
    </div>
</template>
