import { createSSRApp, h } from 'vue'
import { renderToString } from '@vue/server-renderer'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import createServer from '@inertiajs/server'
// @ts-ignore
import { ZiggyVue } from "ziggy"
import { Ziggy } from "@/helpers/ziggy"
import {createPinia} from "pinia";
import {initFromPageProps} from "@/admin/inertia/store";


const pinia = createPinia()

createServer((page) => createInertiaApp({
    page,
    render: renderToString,
    resolve: name => require(`./Pages/${name}`),
    setup({ app, props, plugin }) {
        try {
            return createSSRApp({ render: () => h(app, props) })
                .use(plugin)
                .use(ZiggyVue, Ziggy)
            // walkaround for passing page props to pinia
        } finally {
            initFromPageProps(pinia, props?.initialPage?.props)
        }
    },
}))
