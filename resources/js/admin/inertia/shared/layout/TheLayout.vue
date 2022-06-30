<script lang="ts" setup>
import TheHeader from "@/admin/inertia/shared/layout/TheHeader.vue"
import TheSidebar2 from "@/admin/inertia/shared/layout/TheSidebar2.vue"

</script>

<template>
    <div id="wrapper" class="wrapper">
        <TheHeader />
        <main class="d-flex">
            <div id="resize-container" class="">
                <TheSidebar2 />
                <div id="resizer"></div>
                <div class="" id="content">
                    <slot></slot>
                </div>
            </div>
        </main>
    </div>
</template>
