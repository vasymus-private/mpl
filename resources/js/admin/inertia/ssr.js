import { createSSRApp, h } from "vue"
import { renderToString } from "@vue/server-renderer"
import { createInertiaApp } from "@inertiajs/inertia-vue3"
import createServer from "@inertiajs/server"
import { ZiggyVue } from "ziggy-js/dist/vue"
import { createPinia } from "pinia"
import { initFromPageProps } from "@/admin/inertia/modules"
import { getAmendedZiggyConfig } from "@/admin/inertia/utils"

createServer((page) =>
    createInertiaApp({
        page,
        render: renderToString,
        resolve: (name) => require(`./Pages/${name}`),
        setup({ app, props, plugin }) {
            const pinia = createPinia()
            let initialPageProps = props.initialPage.props

            let ziggyConfig = getAmendedZiggyConfig(initialPageProps.fullUrl)
            try {
                return createSSRApp({ render: () => h(app, props) })
                    .use(plugin)
                    .use(ZiggyVue, ziggyConfig)
                    .use(pinia)
                // workaround for passing page props to pinia
            } finally {
                initFromPageProps(pinia, initialPageProps)
            }
        },
    })
)
