export default {
    computed: {
        routeNames() {
            /**
             * @see src/App/Constants.php
             */
            return {
                ROUTE_ADMIN_HOME : 'admin.home',
                ROUTE_ADMIN_MEDIA : 'admin.media',

                ROUTE_ADMIN_PRODUCTS_INDEX : 'admin.products.index',
                ROUTE_ADMIN_PRODUCTS_CREATE : 'admin.products.create',
                ROUTE_ADMIN_PRODUCTS_EDIT : 'admin.products.edit',

                ROUTE_TEMP_ADMIN_PRODUCTS_INDEX : 'admin.temp.products.index',
                ROUTE_TEMP_ADMIN_PRODUCTS_CREATE : 'admin.temp.products.create',
                ROUTE_TEMP_ADMIN_PRODUCTS_EDIT : 'admin.temp.products.edit',

                ROUTE_ADMIN_CATEGORIES_INDEX : 'admin.categories.index',
                ROUTE_ADMIN_CATEGORIES_CREATE : 'admin.categories.create',
                ROUTE_ADMIN_CATEGORIES_EDIT : 'admin.categories.edit',

                ROUTE_ADMIN_BRANDS_INDEX : 'admin.brands.index',
                ROUTE_ADMIN_BRANDS_CREATE : 'admin.brands.create',
                ROUTE_ADMIN_BRANDS_EDIT : 'admin.brands.edit',

                ROUTE_ADMIN_ORDERS_INDEX : 'admin.orders.index',
                ROUTE_ADMIN_ORDERS_CREATE : 'admin.orders.create',
                ROUTE_ADMIN_ORDERS_EDIT : 'admin.orders.edit',

                ROUTE_ADMIN_ARTICLES_INDEX : 'admin.articles.index',
                ROUTE_ADMIN_ARTICLES_CREATE : 'admin.articles.create',
                ROUTE_ADMIN_ARTICLES_EDIT : 'admin.articles.edit',

                ROUTE_ADMIN_SERVICES_INDEX : 'admin.services.index',
                ROUTE_ADMIN_SERVICES_CREATE : 'admin.services.create',
                ROUTE_ADMIN_SERVICES_EDIT : 'admin.services.edit',

                ROUTE_ADMIN_EXPORT_PRODUCTS_INDEX : 'admin.export-products.index',
                ROUTE_ADMIN_EXPORT_PRODUCTS_SHOW : 'admin.export-products.show',
                ROUTE_ADMIN_EXPORT_PRODUCTS_STORE : 'admin.export-products.store',
                ROUTE_ADMIN_EXPORT_PRODUCTS_DELETE : 'admin.export-products.delete',
            }
        }
    }
}
