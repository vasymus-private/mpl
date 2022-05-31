<template>
    <div id="wrapper" class="wrapper">
        <the-header />
        <main class="d-flex">
            <div id="resize-container" class="">
                <the-sidebar />
                <div id="resizer"></div>
                <div class="" id="content">
                    <slot />
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import TheHeader from '@/admin/shared/layout/TheHeader'
import TheSidebar from '@/admin/shared/layout/TheSidebar'

export default {
    components: {
        TheHeader,
        TheSidebar
    }
}
</script>
