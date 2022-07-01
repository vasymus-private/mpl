import {routeNames} from "@/admin/inertia/modules/routes";

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
