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
        "ignition.healthCheck": {
            uri: "_ignition/health-check",
            methods: ["GET", "HEAD"],
        },
        "ignition.executeSolution": {
            uri: "_ignition/execute-solution",
            methods: ["POST"],
        },
        "ignition.updateConfig": {
            uri: "_ignition/update-config",
            methods: ["POST"],
        },
        "admin.home": { uri: "admin/home", methods: ["GET", "HEAD"] },
        "admin.temp.home": { uri: "admin/home-temp", methods: ["GET", "HEAD"] },
        "admin.media": {
            uri: "admin/media/{id}/{name?}",
            methods: ["GET", "HEAD"],
        },
        "admin.products.index": {
            uri: "admin/products",
            methods: ["GET", "HEAD"],
        },
        "admin.products.temp.index": {
            uri: "admin/temp-products",
            methods: ["GET", "HEAD"],
        },
        "admin.products.create": {
            uri: "admin/products/create",
            methods: ["GET", "HEAD"],
        },
        "admin.products.temp.create": {
            uri: "admin/temp-products/create",
            methods: ["GET", "HEAD"],
        },
        "admin.products.edit": {
            uri: "admin/products/{admin_product}/edit",
            methods: ["GET", "HEAD"],
        },
        "admin.products.temp.edit": {
            uri: "admin/temp-products/{admin_product}/edit",
            methods: ["GET", "HEAD"],
        },
        "admin.categories.index": {
            uri: "admin/categories",
            methods: ["GET", "HEAD"],
        },
        "admin.categories.temp.index": {
            uri: "admin/temp-categories",
            methods: ["GET", "HEAD"],
        },
        "admin.categories.create": {
            uri: "admin/categories/create",
            methods: ["GET", "HEAD"],
        },
        "admin.categories.temp.create": {
            uri: "admin/temp-categories/create",
            methods: ["GET", "HEAD"],
        },
        "admin.categories.edit": {
            uri: "admin/categories/{admin_category}/edit",
            methods: ["GET", "HEAD"],
        },
        "admin.categories.temp.edit": {
            uri: "admin/temp-categories/{admin_category}/edit",
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
        "admin.brands.temp.index": {
            uri: "admin/temp-brands",
            methods: ["GET", "HEAD"],
        },
        "admin.brands.temp.create": {
            uri: "admin/temp-brands/create",
            methods: ["GET", "HEAD"],
        },
        "admin.brands.temp.edit": {
            uri: "admin/temp-brands/{admin_brand}/edit",
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
        "admin.orders.temp.index": {
            uri: "admin/orders-temp",
            methods: ["GET", "HEAD"],
        },
        "admin.orders.temp.create": {
            uri: "admin/orders-temp/create",
            methods: ["GET", "HEAD"],
        },
        "admin.orders.temp.edit": {
            uri: "admin/orders-temp/{admin_order}/edit",
            methods: ["GET", "HEAD"],
        },
        "admin.faq.index": { uri: "admin/faqs", methods: ["GET", "HEAD"] },
        "admin.faq.create": {
            uri: "admin/faqs/create",
            methods: ["GET", "HEAD"],
        },
        "admin.faq.edit": {
            uri: "admin/faqs/{admin_faq}/edit",
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
        "admin.articles.create": {
            uri: "admin/articles/create",
            methods: ["GET", "HEAD"],
        },
        "admin.articles.edit": {
            uri: "admin/articles/{admin_article}/edit",
            methods: ["GET", "HEAD"],
        },
        "admin.gallery-items.index": {
            uri: "admin/gallery-items",
            methods: ["GET", "HEAD"],
        },
        "admin.gallery-items.create": {
            uri: "admin/gallery-items/create",
            methods: ["GET", "HEAD"],
        },
        "admin.gallery-items.edit": {
            uri: "admin/gallery-items/{admin_gallery_item}/edit",
            methods: ["GET", "HEAD"],
        },
        "admin.test.inertia": {
            uri: "admin/---test-inertia",
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
        "admin-ajax.products.bulk.update": {
            uri: "admin-ajax/products-bulk",
            methods: ["PUT"],
        },
        "admin-ajax.products.bulk.delete": {
            uri: "admin-ajax/products-bulk",
            methods: ["DELETE"],
        },
        "admin-ajax.categories.bulk.update": {
            uri: "admin-ajax/categories-bulk",
            methods: ["PUT"],
        },
        "admin-ajax.categories.bulk.delete": {
            uri: "admin-ajax/categories-bulk",
            methods: ["DELETE"],
        },
        "admin-ajax.brands.bulk.update": {
            uri: "admin-ajax/brands-bulk",
            methods: ["PUT"],
        },
        "admin-ajax.brands.bulk.delete": {
            uri: "admin-ajax/brands-bulk",
            methods: ["DELETE"],
        },
        "admin-ajax.faq.bulk.update": {
            uri: "admin-ajax/faq-bulk",
            methods: ["PUT"],
        },
        "admin-ajax.faq.bulk.delete": {
            uri: "admin-ajax/faq-bulk",
            methods: ["DELETE"],
        },
        "admin-ajax.article.bulk.update": {
            uri: "admin-ajax/article-bulk",
            methods: ["PUT"],
        },
        "admin-ajax.article.bulk.delete": {
            uri: "admin-ajax/article-bulk",
            methods: ["DELETE"],
        },
        "admin-ajax.gallery-item.bulk.update": {
            uri: "admin-ajax/gallery-items-bulk",
            methods: ["PUT"],
        },
        "admin-ajax.gallery-item.bulk.delete": {
            uri: "admin-ajax/gallery-items-bulk",
            methods: ["DELETE"],
        },
        "admin-ajax.products.store": {
            uri: "admin-ajax/product",
            methods: ["POST"],
        },
        "admin-ajax.products.update": {
            uri: "admin-ajax/product/{admin_product}",
            methods: ["PUT"],
        },
        "admin-ajax.categories.store": {
            uri: "admin-ajax/category",
            methods: ["POST"],
        },
        "admin-ajax.categories.update": {
            uri: "admin-ajax/category/{admin_category}",
            methods: ["PUT"],
        },
        "admin-ajax.brands.store": {
            uri: "admin-ajax/brand",
            methods: ["POST"],
        },
        "admin-ajax.brands.update": {
            uri: "admin-ajax/brand/{admin_brand}",
            methods: ["PUT"],
        },
        "admin-ajax.faq.store": { uri: "admin-ajax/faq", methods: ["POST"] },
        "admin-ajax.faq.update": {
            uri: "admin-ajax/faq/{admin_faq}",
            methods: ["PUT"],
        },
        "admin-ajax.article.store": {
            uri: "admin-ajax/article",
            methods: ["POST"],
        },
        "admin-ajax.article.update": {
            uri: "admin-ajax/article/{admin_article}",
            methods: ["PUT"],
        },
        "admin-ajax.gallery-item.store": {
            uri: "admin-ajax/gallery-items",
            methods: ["POST"],
        },
        "admin-ajax.gallery-item.update": {
            uri: "admin-ajax/gallery-items/{admin_gallery_item}",
            methods: ["PUT"],
        },
        "admin-ajax.orders.store": {
            uri: "admin-ajax/order",
            methods: ["POST"],
        },
        "admin-ajax.orders.update": {
            uri: "admin-ajax/order/{admin_order}",
            methods: ["PUT"],
        },
        "admin-ajax.orders.cancel": {
            uri: "admin-ajax/order-cancel/{admin_order}",
            methods: ["PUT"],
        },
        "admin-ajax.order-event.index": {
            uri: "admin-ajax/order/{admin_order}/order-events",
            methods: ["GET", "HEAD"],
        },
        "admin-ajax.sort-columns": {
            uri: "admin-ajax/sort-columns",
            methods: ["PUT"],
        },
        "admin-ajax.helper": {
            uri: "admin-ajax/helper/slug",
            methods: ["POST"],
        },
        "admin-ajax.product-image-upload": {
            uri: "admin-ajax/product-image-upload/{admin_product}",
            methods: ["POST"],
        },
        "admin-ajax.category-image-upload": {
            uri: "admin-ajax/category-image-upload/{admin_category}",
            methods: ["POST"],
        },
        "admin-ajax.brand-image-upload": {
            uri: "admin-ajax/brand-image-upload/{admin_brand}",
            methods: ["POST"],
        },
        "admin-ajax.faq-image-upload": {
            uri: "admin-ajax/faq-image-upload/{admin_faq}",
            methods: ["POST"],
        },
        "admin-ajax.article-image-upload": {
            uri: "admin-ajax/article-image-upload/{admin_article}",
            methods: ["POST"],
        },
        "admin-ajax.product-search": {
            uri: "admin-ajax/product-search",
            methods: ["GET", "HEAD"],
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
        "parquet-works-product.show": {
            uri: "{product_slug}",
            methods: ["GET", "HEAD"],
        },
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
