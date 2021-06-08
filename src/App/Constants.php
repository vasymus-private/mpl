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

    public const ROUTE_ADMIN_HOME = 'admin.home';
    public const ROUTE_ADMIN_PRODUCTS_INDEX = 'admin.products.index';
    public const ROUTE_ADMIN_PRODUCTS_CREATE = 'admin.products.create';
    public const ROUTE_ADMIN_PRODUCTS_EDIT = 'admin.products.edit';
    public const ROUTE_ADMIN_CATEGORIES_INDEX = 'admin.categories.index';
    public const ROUTE_ADMIN_CATEGORIES_CREATE = 'admin.categories.create';
    public const ROUTE_ADMIN_CATEGORIES_EDIT = 'admin.categories.edit';
    public const ROUTE_ADMIN_BRANDS_INDEX = 'admin.brands.index';
    public const ROUTE_ADMIN_BRANDS_CREATE = 'admin.brands.create';
    public const ROUTE_ADMIN_BRANDS_EDIT = 'admin.brands.edit';


    private function __construct() {}
}
