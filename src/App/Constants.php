<?php

namespace App;

final class Constants
{
    const MIDDLEWARE_AUTHENTICATE_ALL = "authenticate-all";
    const MIDDLEWARE_REDIRECT_IF_IDENTIFIED = "redirect-if-identified";

    const MIDDLEWARE_REDIRECT_IF_NOT_IDENTIFIED = "redirect-if-not-identified";

    const AUTH_GUARD_ADMIN = "admin";

    const MIME_JPEG = "image/jpeg";
    const MIME_GIF = "image/gif";
    const MIME_PNG = "image/png";
    const MIME_HTML = "text/html";
    const MIME_PDF = "application/pdf";
    const MIME_DOCX = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
    const MIME_DOC = "application/msword";
    const MIME_PPTX = "application/vnd.openxmlformats-officedocument.presentationml.presentation";
    const MIME_PPT = "application/vnd.ms-powerpoint";
    const MIME_XLSX = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
    const MIME_XLS = "application/vnd.ms-excel";


    private function __construct() {}
}
