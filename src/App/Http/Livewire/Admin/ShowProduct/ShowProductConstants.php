<?php

namespace App\Http\Livewire\Admin\ShowProduct;

final class ShowProductConstants
{
    public const EVENT_SAVE_ELEMENTS = 'saveElements';

    public const EVENT_SAVE_DESCRIPTIONS = 'saveDescription';

    public const EVENT_SAVE_PHOTO = 'savePhoto';

    public const EVENT_SAVE_CHARACTERISTICS = 'saveCharacteristics';

    public const EVENT_HANDLE_REDIRECT = 'handleRedirect';

    public const MAX_FILE_SIZE_MB = 30;

    private function __construct() {}
}
