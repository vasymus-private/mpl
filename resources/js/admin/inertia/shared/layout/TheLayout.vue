<template>
    <div id="wrapper" class="wrapper">
        <TheHeader />
        <main class="d-flex">
            <div id="resize-container" class="">
<!--                <the-sidebar />-->
                <div id="resizer"></div>
                <div class="" id="content">
                    <slot />
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import TheHeader from './TheHeader'
// import TheSidebar from './TheSidebar'

export default {
    components: {
        TheHeader,
        // TheSidebar
    }
}
</script>
