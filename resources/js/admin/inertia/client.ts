import { createApp, h } from "vue"
import { createInertiaApp } from "@inertiajs/inertia-vue3"
// @ts-ignore
import { ZiggyVue } from "ziggy"
// @ts-ignore
import { Ziggy } from "@/helpers/ziggy"
import { InertiaProgress } from '@inertiajs/progress'
import { createPinia } from 'pinia'


const pinia = createPinia()

createInertiaApp({
    resolve: (name) => {
        console.log("name", name)
        return require(`./Pages/${name}.vue`).default
    },
    // @ts-ignore
    setup({ el, App, props, plugin, ...rest }) {
        console.log("--- base setup ---", props, rest)
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(pinia)
            .mount(el)
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
