import { createApp, h } from "vue"
import { createInertiaApp } from "@inertiajs/inertia-vue3"
import { ZiggyVue } from "ziggy-js/src/js/vue"
import { InertiaProgress } from "@inertiajs/progress"
import { createPinia } from "pinia"
import { initFromPageProps, InitialPageProps } from "@/admin/inertia/modules"
import "bootstrap"
import { Inertia } from "@inertiajs/inertia"
import "ckeditor5-custom-build/build/ckeditor"
import "@/admin/inertia/vendor/vue-multiselect/vue-multiselect.css"
import axios from "axios"
import { getAmendedZiggyConfig } from "@/admin/inertia/utils"

const pinia = createPinia()
//
// Inertia.on('before', (event) => {
//     console.log('--- before')
// })
//
// Inertia.on('start', (event) => {
//     console.log('--- start')
// })
//
// Inertia.on('progress', (event) => {
//     console.log('--- progress')
// })
//
// Inertia.on('success', (event) => {
//     console.log('--- success')
// })
//
// Inertia.on('navigate', (event) => {
//     console.log('--- navigate')
// })
//
// Inertia.on('error', (event) => {
//     console.log('--- error')
// })
//
// Inertia.on('finish', (event) => {
//     console.log('--- finish')
// })

Inertia.on("navigate", (event) => {
    initFromPageProps(
        pinia,
        event.detail.page.props as unknown as InitialPageProps
    )
})

createInertiaApp({
    resolve: (name) => require(`./Pages/${name}`),
    // @ts-ignore
    setup({ el, App, props, plugin }) {
        // console.log(el, App, props, plugin)

        let initialPageProps: InitialPageProps = props.initialPage
            .props as unknown as InitialPageProps

        let ziggyConfig = getAmendedZiggyConfig(initialPageProps.fullUrl)

        try {
            return createApp({ render: () => h(App, props) })
                .use(plugin)
                .use(ZiggyVue, ziggyConfig)
                .use(pinia)
                .mount(el)
            // walkaround for passing page props to pinia
        } finally {
            initFromPageProps(pinia, initialPageProps)
        }
    },
})

InertiaProgress.init({
    // The delay after which the progress bar will
    // appear during navigation, in milliseconds.
    delay: 250,

    // The color of the progress bar.
    color: "#f00",

    // Whether to include the default NProgress styles.
    includeCSS: false,

    // Whether the NProgress spinner will be shown.
    showSpinner: true,
})

if (typeof window !== "undefined") {
    // @ts-ignore
    window.___axios = axios
}
