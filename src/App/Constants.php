<?php

namespace App;

final class Constants
{
    public const MIDDLEWARE_AUTHENTICATE_ALL = "authenticate-all";
    public const MIDDLEWARE_REDIRECT_IF_IDENTIFIED = "redirect-if-identified";

    public const AUTH_GUARD_WEB = "web";
    public const AUTH_GUARD_ADMIN = "admin";

    public const MIME_JPEG = "image/jpeg";
    public const MIME_GIF = "image/gif";
    public const MIME_PNG = "image/png";
    public const MIME_HTML = "text/html";
    public const MIME_PDF = "application/pdf";
    public const MIME_DOCX = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
    public const MIME_DOC = "application/msword";
    public const MIME_PPTX = "application/vnd.openxmlformats-officedocument.presentationml.presentation";
    public const MIME_PPT = "application/vnd.ms-powerpoint";
    public const MIME_XLSX = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
    public const MIME_XLS = "application/vnd.ms-excel";
    public const MIME_ZIP = 'application/zip';
    public const MIME_VIDEO_AVI = 'video/avi';
    public const MIME_VIDEO_MPEG = 'video/mpeg';
    public const MIME_VIDEO_QUICKTIME = 'video/quicktime';

    public const ROUTE_WEB_HOME = 'home';

    public const ROUTE_WEB_FAQ_INDEX = 'faq.index';
    public const ROUTE_WEB_FAQ_SHOW = 'faq.show';

    public const ROUTE_LOGOUT = 'logout';

    public const ROUTE_ADMIN_HOME = 'admin.home';
    public const ROUTE_ADMIN_TEMP_HOME = 'admin.temp.home';
    public const ROUTE_ADMIN_MEDIA = 'admin.media';

    public const ROUTE_ADMIN_PRODUCTS_INDEX = 'admin.products.index';
    public const ROUTE_ADMIN_PRODUCTS_CREATE = 'admin.products.create';
    public const ROUTE_ADMIN_PRODUCTS_EDIT = 'admin.products.edit';

    public const ROUTE_ADMIN_PRODUCTS_TEMP_INDEX = 'admin.products.temp.index';
    public const ROUTE_ADMIN_PRODUCTS_TEMP_CREATE = 'admin.products.temp.create';
    public const ROUTE_ADMIN_PRODUCTS_TEMP_EDIT = 'admin.products.temp.edit';

    public const ROUTE_ADMIN_CATEGORIES_INDEX = 'admin.categories.index';
    public const ROUTE_ADMIN_CATEGORIES_CREATE = 'admin.categories.create';
    public const ROUTE_ADMIN_CATEGORIES_EDIT = 'admin.categories.edit';

    public const ROUTE_ADMIN_CATEGORIES_TEMP_INDEX = 'admin.categories.temp.index';
    public const ROUTE_ADMIN_CATEGORIES_TEMP_CREATE = 'admin.categories.temp.create';
    public const ROUTE_ADMIN_CATEGORIES_TEMP_EDIT = 'admin.categories.temp.edit';

    public const ROUTE_ADMIN_BRANDS_INDEX = 'admin.brands.index';
    public const ROUTE_ADMIN_BRANDS_CREATE = 'admin.brands.create';
    public const ROUTE_ADMIN_BRANDS_EDIT = 'admin.brands.edit';

    public const ROUTE_ADMIN_BRANDS_TEMP_INDEX = 'admin.brands.temp.index';
    public const ROUTE_ADMIN_BRANDS_TEMP_CREATE = 'admin.brands.temp.create';
    public const ROUTE_ADMIN_BRANDS_TEMP_EDIT = 'admin.brands.temp.edit';

    public const ROUTE_ADMIN_ORDERS_INDEX = 'admin.orders.index';
    public const ROUTE_ADMIN_ORDERS_CREATE = 'admin.orders.create';
    public const ROUTE_ADMIN_ORDERS_EDIT = 'admin.orders.edit';

    public const ROUTE_ADMIN_ORDERS_TEMP_INDEX = 'admin.orders.temp.index';
    public const ROUTE_ADMIN_ORDERS_TEMP_CREATE = 'admin.orders.temp.create';
    public const ROUTE_ADMIN_ORDERS_TEMP_EDIT = 'admin.orders.temp.edit';

    public const ROUTE_ADMIN_ARTICLES_INDEX = 'admin.articles.index';
    public const ROUTE_ADMIN_ARTICLES_CREATE = 'admin.articles.create';
    public const ROUTE_ADMIN_ARTICLES_EDIT = 'admin.articles.edit';

    public const ROUTE_ADMIN_FAQ_INDEX = 'admin.faq.index';
    public const ROUTE_ADMIN_FAQ_CREATE = 'admin.faq.create';
    public const ROUTE_ADMIN_FAQ_EDIT = 'admin.faq.edit';

    public const ROUTE_ADMIN_GALLERY_ITEMS_INDEX = 'admin.gallery-items.index';
    public const ROUTE_ADMIN_GALLERY_ITEMS_CREATE = 'admin.gallery-items.create';
    public const ROUTE_ADMIN_GALLERY_ITEMS_EDIT = 'admin.gallery-items.edit';

    public const ROUTE_ADMIN_CONTACT_FORMS_INDEX = 'admin.contact-forms.index';
    public const ROUTE_ADMIN_CONTACT_FORMS_SHOW = 'admin.contact-forms.create';

    public const ROUTE_ADMIN_EXPORT_PRODUCTS_INDEX = 'admin.export-products.index';
    public const ROUTE_ADMIN_EXPORT_PRODUCTS_SHOW = 'admin.export-products.show';
    public const ROUTE_ADMIN_EXPORT_PRODUCTS_STORE = 'admin.export-products.store';
    public const ROUTE_ADMIN_EXPORT_PRODUCTS_DELETE = 'admin.export-products.delete';

    public const ROUTE_ADMIN_AJAX_PRODUCTS_BULK_UPDATE = 'admin-ajax.products.bulk.update';
    public const ROUTE_ADMIN_AJAX_PRODUCTS_BULK_DELETE = 'admin-ajax.products.bulk.delete';

    public const ROUTE_ADMIN_AJAX_CATEGORIES_BULK_UPDATE = 'admin-ajax.categories.bulk.update';
    public const ROUTE_ADMIN_AJAX_CATEGORIES_BULK_DELETE = 'admin-ajax.categories.bulk.delete';

    public const ROUTE_ADMIN_AJAX_BRANDS_BULK_UPDATE = 'admin-ajax.brands.bulk.update';
    public const ROUTE_ADMIN_AJAX_BRANDS_BULK_DELETE = 'admin-ajax.brands.bulk.delete';

    public const ROUTE_ADMIN_AJAX_FAQ_BULK_UPDATE = 'admin-ajax.faq.bulk.update';
    public const ROUTE_ADMIN_AJAX_FAQ_BULK_DELETE = 'admin-ajax.faq.bulk.delete';

    public const ROUTE_ADMIN_AJAX_ARTICLE_BULK_UPDATE = 'admin-ajax.article.bulk.update';
    public const ROUTE_ADMIN_AJAX_ARTICLE_BULK_DELETE = 'admin-ajax.article.bulk.delete';

    public const ROUTE_ADMIN_AJAX_GALLERY_ITEMS_BULK_UPDATE = 'admin-ajax.gallery-item.bulk.update';
    public const ROUTE_ADMIN_AJAX_GALLERY_ITEMS_BULK_DELETE = 'admin-ajax.gallery-item.bulk.delete';

    public const ROUTE_ADMIN_AJAX_CONTACT_FORMS_BULK_DELETE = 'admin-ajax.contact-forms.bulk.delete';

    public const ROUTE_ADMIN_AJAX_PRODUCTS_STORE = 'admin-ajax.products.store';
    public const ROUTE_ADMIN_AJAX_PRODUCTS_UPDATE = 'admin-ajax.products.update';

    public const ROUTE_ADMIN_AJAX_CATEGORIES_STORE = 'admin-ajax.categories.store';
    public const ROUTE_ADMIN_AJAX_CATEGORIES_UPDATE = 'admin-ajax.categories.update';

    public const ROUTE_ADMIN_AJAX_BRANDS_STORE = 'admin-ajax.brands.store';
    public const ROUTE_ADMIN_AJAX_BRANDS_UPDATE = 'admin-ajax.brands.update';

    public const ROUTE_ADMIN_AJAX_FAQ_STORE = 'admin-ajax.faq.store';
    public const ROUTE_ADMIN_AJAX_FAQ_UPDATE = 'admin-ajax.faq.update';

    public const ROUTE_ADMIN_AJAX_ARTICLE_STORE = 'admin-ajax.article.store';
    public const ROUTE_ADMIN_AJAX_ARTICLE_UPDATE = 'admin-ajax.article.update';

    public const ROUTE_ADMIN_AJAX_GALLERY_ITEM_STORE = 'admin-ajax.gallery-item.store';
    public const ROUTE_ADMIN_AJAX_GALLERY_ITEM_UPDATE = 'admin-ajax.gallery-item.update';

    public const ROUTE_ADMIN_AJAX_ORDERS_STORE = 'admin-ajax.orders.store';
    public const ROUTE_ADMIN_AJAX_ORDERS_UPDATE = 'admin-ajax.orders.update';
    public const ROUTE_ADMIN_AJAX_ORDERS_CANCEL = 'admin-ajax.orders.cancel';

    public const ROUTE_ADMIN_AJAX_ORDER_EVENTS_INDEX = 'admin-ajax.order-event.index';

    public const ROUTE_ADMIN_AJAX_PROFILE_UPDATE = 'admin-ajax.profile.update';
    public const ROUTE_ADMIN_AJAX_HELPER = 'admin-ajax.helper';

    public const ROUTE_ADMIN_AJAX_PRODUCT_IMAGE_UPLOAD = 'admin-ajax.product-image-upload';
    public const ROUTE_ADMIN_AJAX_CATEGORY_IMAGE_UPLOAD = 'admin-ajax.category-image-upload';
    public const ROUTE_ADMIN_AJAX_BRAND_IMAGE_UPLOAD = 'admin-ajax.brand-image-upload';
    public const ROUTE_ADMIN_AJAX_FAQ_IMAGE_UPLOAD = 'admin-ajax.faq-image-upload';
    public const ROUTE_ADMIN_AJAX_ARTICLE_IMAGE_UPLOAD = 'admin-ajax.article-image-upload';

    public const ROUTE_ADMIN_AJAX_PRODUCT_SEARCH = 'admin-ajax.product-search';

    public const MEDIA_DISK_PUBLIC = 'public';
    public const MEDIA_DISK_PRIVATE = 'private-media';
    public const MEDIA_PREFIX = 'media';
    public const MEDIA_DISK_S3_PUBLIC = 's3';
    public const MEDIA_DISK_S3_PRIVATE = 's3-private';
    public const MEDIA_CLOUD_DISKS = [
        self::MEDIA_DISK_S3_PUBLIC,
        self::MEDIA_DISK_S3_PRIVATE,
    ];

    private function __construct()
    {
    }
}
