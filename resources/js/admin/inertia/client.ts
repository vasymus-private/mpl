import { createApp, h } from "vue"
import { createInertiaApp } from "@inertiajs/inertia-vue3"
import { ZiggyVue } from "ziggy-js/src/js/vue"
import { Ziggy } from "@/helpers/ziggy"
import { InertiaProgress } from "@inertiajs/progress"
import { createPinia } from "pinia"
import { initFromPageProps } from "@/admin/inertia/modules"
import "bootstrap"
import { Inertia } from "@inertiajs/inertia"
import "ckeditor5-custom-build/build/ckeditor"
import "vue-multiselect/dist/vue-multiselect.css"
import "@/admin/inertia/settings/vee-validate"

const pinia = createPinia()
Inertia.on("navigate", (event) => {
    initFromPageProps(pinia, event.detail.page.props)
})

createInertiaApp({
    resolve: (name) => require(`./Pages/${name}`),
    // @ts-ignore
    setup({ el, App, props, plugin }) {
        // console.log(el, App, props, plugin)
        try {
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
    color: "#f00",

    // Whether to include the default NProgress styles.
    includeCSS: false,

    // Whether the NProgress spinner will be shown.
    showSpinner: true,
})
