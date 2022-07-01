import { createApp, h } from "vue"
import { createInertiaApp } from "@inertiajs/inertia-vue3"
import {ZiggyVue} from "ziggy-js/src/js/vue";
import { Ziggy } from "@/helpers/ziggy"
import { InertiaProgress } from "@inertiajs/progress"
import { createPinia } from "pinia"
import { initFromPageProps } from "@/admin/inertia/modules"
import "bootstrap"


createInertiaApp({
    resolve: (name) => require(`./Pages/${name}`),
    // @ts-ignore
    setup({ el, App, props, plugin }) {
        const pinia = createPinia()
        try {
            // console.log("--- base setup ---")
            // console.log('--- App ---', App)
            // console.log('--- props ---', props)
            return createApp({ render: () => h(App, props) })
                .use(plugin)
                .use(ZiggyVue, Ziggy)
                .use(pinia)
                .mount(el)
            // walkaround for passing page props to pinia
        } finally {
            initFromPageProps(pinia, props?.initialPage?.props)
        }
    },
})

InertiaProgress.init({
    // The delay after which the progress bar will
    // appear during navigation, in milliseconds.
    delay: 250,

    // The color of the progress bar.
    color: "#29d",

    // Whether to include the default NProgress styles.
    includeCSS: true,

    // Whether the NProgress spinner will be shown.
    showSpinner: false,
})
