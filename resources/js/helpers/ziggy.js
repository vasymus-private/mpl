const Ziggy = {
    url: "http://mpl.localhost",
    port: null,
    defaults: {},
    routes: {
        "debugbar.openhandler": {
            uri: "_debugbar/open",
            methods: ["GET", "HEAD"],
        },
        "debugbar.clockwork": {
            uri: "_debugbar/clockwork/{id}",
            methods: ["GET", "HEAD"],
        },
        "debugbar.assets.css": {
            uri: "_debugbar/assets/stylesheets",
            methods: ["GET", "HEAD"],
        },
        "debugbar.assets.js": {
            uri: "_debugbar/assets/javascript",
            methods: ["GET", "HEAD"],
        },
        "debugbar.cache.delete": {
            uri: "_debugbar/cache/{key}/{tags?}",
            methods: ["DELETE"],
        },
        "livewire.message": {
            uri: "livewire/message/{name}",
            methods: ["POST"],
        },
        "livewire.upload-file": {
            uri: "livewire/upload-file",
            methods: ["POST"],
        },
        "livewire.preview-file": {
            uri: "livewire/preview-file/{filename}",
            methods: ["GET", "HEAD"],
        },
        "admin.home": { uri: "admin/home", methods: ["GET", "HEAD"] },
        "admin.media": {
            uri: "admin/media/{id}/{name?}",
            methods: ["GET", "HEAD"],
        },
        "admin.products.index": {
            uri: "admin/products",
            methods: ["GET", "HEAD"],
        },
        "admin.products.create": {
            uri: "admin/products/create",
            methods: ["GET", "HEAD"],
        },
        "admin.products.edit": {
            uri: "admin/products/{admin_product}/edit",
            methods: ["GET", "HEAD"],
        },
        "admin.categories.index": {
            uri: "admin/categories",
            methods: ["GET", "HEAD"],
        },
        "admin.categories.create": {
            uri: "admin/categories/create",
            methods: ["GET", "HEAD"],
        },
        "admin.categories.edit": {
            uri: "admin/categories/{admin_category}/edit",
            methods: ["GET", "HEAD"],
        },
        "admin.brands.index": { uri: "admin/brands", methods: ["GET", "HEAD"] },
        "admin.brands.create": {
            uri: "admin/brands/create",
            methods: ["GET", "HEAD"],
        },
        "admin.brands.edit": {
            uri: "admin/brands/{admin_brand}/edit",
            methods: ["GET", "HEAD"],
        },
        "admin.orders.index": { uri: "admin/orders", methods: ["GET", "HEAD"] },
        "admin.orders.create": {
            uri: "admin/orders/create",
            methods: ["GET", "HEAD"],
        },
        "admin.orders.edit": {
            uri: "admin/orders/{admin_order}/edit",
            methods: ["GET", "HEAD"],
        },
        "admin.export-products.index": {
            uri: "admin/export-products",
            methods: ["GET", "HEAD"],
        },
        "admin.export-products.show": {
            uri: "admin/export-products/{id}",
            methods: ["GET", "HEAD"],
        },
        "admin.export-products.store": {
            uri: "admin/export-products",
            methods: ["POST"],
        },
        "admin.export-products.delete": {
            uri: "admin/export-products/{id}",
            methods: ["DELETE"],
        },
        "admin.articles.index": {
            uri: "admin/articles",
            methods: ["GET", "HEAD"],
        },
        "admin.services.index": {
            uri: "admin/services",
            methods: ["GET", "HEAD"],
        },
        "admin-ajax.profile.update": {
            uri: "admin-ajax/profiles/{admin}",
            methods: ["PUT"],
        },
        "admin-ajax.show-order-busy": {
            uri: "admin-ajax/show-order-busy",
            methods: ["POST"],
        },
        "admin-ajax.ping-order-busy": {
            uri: "admin-ajax/ping-order-busy/{id}",
            methods: ["POST"],
        },
        test: { uri: "---test/{id?}/{hash?}", methods: ["GET", "HEAD"] },
        login: { uri: "login", methods: ["GET", "HEAD"] },
        logout: { uri: "logout", methods: ["POST"] },
        "password.request": { uri: "password/reset", methods: ["GET", "HEAD"] },
        "password.email": { uri: "password/email", methods: ["POST"] },
        "password.reset": {
            uri: "password/reset/{token}",
            methods: ["GET", "HEAD"],
        },
        "password.update": { uri: "password/reset", methods: ["POST"] },
        "product.show.1": {
            uri: "catalog/{category_slug}/{product_slug}.html",
            methods: ["GET", "HEAD"],
        },
        "product.show.2": {
            uri: "catalog/{category_slug}/{subcategory1_slug}/{product_slug}.html",
            methods: ["GET", "HEAD"],
        },
        "product.show.3": {
            uri: "catalog/{category_slug}/{subcategory1_slug}/{subcategory2_slug}/{product_slug}.html",
            methods: ["GET", "HEAD"],
        },
        "product.show.4": {
            uri: "catalog/{category_slug}/{subcategory1_slug}/{subcategory2_slug}/{subcategory3_slug}/{product_slug}.html",
            methods: ["GET", "HEAD"],
        },
        "products.index": {
            uri: "catalog/{category_slug?}/{subcategory1_slug?}/{subcategory2_slug?}/{subcategory3_slug?}",
            methods: ["GET", "HEAD"],
        },
        "brands.index": { uri: "brands", methods: ["GET", "HEAD"] },
        "brands.show": {
            uri: "brands/{brand_slug}.html",
            methods: ["GET", "HEAD"],
        },
        "gallery.items.index": { uri: "photos", methods: ["GET", "HEAD"] },
        "gallery.items.show": {
            uri: "photos/{parentGalleryItemSlug}",
            methods: ["GET", "HEAD"],
        },
        "articles.show": {
            uri: "articles/{article_slug}/{subarticle_slug?}",
            methods: ["GET", "HEAD"],
        },
        "faq.index": { uri: "faq", methods: ["GET", "HEAD"] },
        "faq.show": { uri: "faq/{faq_slug}", methods: ["GET", "HEAD"] },
        ask: { uri: "ask", methods: ["GET", "HEAD"] },
        "videos.index": { uri: "videos", methods: ["GET", "HEAD"] },
        howto: { uri: "howto", methods: ["GET", "HEAD"] },
        delivery: { uri: "delivery", methods: ["GET", "HEAD"] },
        return: { uri: "return", methods: ["GET", "HEAD"] },
        contacts: { uri: "contacts", methods: ["GET", "HEAD"] },
        viewed: { uri: "viewed", methods: ["GET", "HEAD"] },
        aside: { uri: "aside", methods: ["GET", "HEAD"] },
        "cart.show": { uri: "cart", methods: ["GET", "HEAD"] },
        "cart.success": {
            uri: "cart-success/{order_id}",
            methods: ["GET", "HEAD"],
        },
        "cart.checkout": { uri: "cart-checkout", methods: ["POST"] },
        profile: { uri: "profile", methods: ["GET", "HEAD"] },
        "orders.show": { uri: "orders/{id}", methods: ["GET", "HEAD"] },
        "profile.identify": {
            uri: "profile-identify/{id}/{email}/{hash}",
            methods: ["GET", "HEAD"],
        },
        media: { uri: "media/{id}/{name?}", methods: ["GET", "HEAD"] },
        "services.show": { uri: "{service_slug}", methods: ["GET", "HEAD"] },
        home: { uri: "/", methods: ["GET", "HEAD"] },
        "ajax.products.aside.store": {
            uri: "ajax/products/aside",
            methods: ["POST"],
        },
        "ajax.products.aside.delete": {
            uri: "ajax/products/aside",
            methods: ["DELETE"],
        },
        "ajax.products.cart.index": {
            uri: "ajax/products/cart",
            methods: ["GET", "HEAD"],
        },
        "ajax.products.cart.store": {
            uri: "ajax/products/cart",
            methods: ["POST"],
        },
        "ajax.products.cart.update": {
            uri: "ajax/products/cart",
            methods: ["PUT"],
        },
        "ajax.products.cart.delete": {
            uri: "ajax/products/cart",
            methods: ["DELETE"],
        },
        "ajax.orders.update": { uri: "ajax/orders/{id}", methods: ["POST"] },
    },
}

if (typeof window !== "undefined" && typeof window.Ziggy !== "undefined") {
    Object.assign(Ziggy.routes, window.Ziggy.routes)
}

export { Ziggy }
