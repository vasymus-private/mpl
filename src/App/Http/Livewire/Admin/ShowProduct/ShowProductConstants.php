<?php

namespace App\Http\Livewire\Admin\ShowProduct;

final class ShowProductConstants
{
    public const EVENT_VALIDATION_NOTIFICATION = 'validationNotification';

    public const COMPONENT_NAME_SHOW_PRODUCT = 'admin.show-product.show-product';
    public const COMPONENT_NAME_CHARACTERISTICS = 'admin.show-product.characteristics';
    public const COMPONENT_NAME_ELEMENTS = 'admin.show-product.elements';
    public const COMPONENT_NAME_PHOTO = 'admin.show-product.photo';
    public const COMPONENT_NAME_DESCRIPTION = 'admin.show-product.description';
    public const COMPONENT_NAME_SEO = 'admin.show-product.seo';

    public const MAX_FILE_SIZE_MB = 30;

    private function __construct()
    {
    }
}
