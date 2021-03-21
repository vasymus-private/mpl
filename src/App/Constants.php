<?php

namespace App;

final class Constants
{
    const MIDDLEWARE_AUTHENTICATE_ALL = "authenticate-all";
    const MIDDLEWARE_REDIRECT_IF_IDENTIFIED = "redirect-if-identified";

    const MIDDLEWARE_REDIRECT_IF_NOT_IDENTIFIED = "redirect-if-not-identified";

    const AUTH_GUARD_ADMIN = "admin";

    private function __construct() {}
}