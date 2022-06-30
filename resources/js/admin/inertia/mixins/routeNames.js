import { routeNames } from "@/admin/inertia/shared/ziggyRoutes"

export default {
    computed: {
        routeNames() {
            /**
             * @see src/App/Constants.php
             */
            return {
                ...routeNames,
            }
        },
    },
}
