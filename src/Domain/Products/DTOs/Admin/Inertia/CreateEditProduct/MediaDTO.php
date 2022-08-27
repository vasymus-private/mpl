<?php

namespace Domain\Products\DTOs\Admin\Inertia\CreateEditProduct;

use Illuminate\Http\UploadedFile;
use Spatie\DataTransferObject\DataTransferObject;

class MediaDTO extends DataTransferObject
{
    /**
     * @var int|null
     */
    public ?int $id;

    /**
     * @var string|null
     */
    public ?string $uuid;

    /**
     * @var string|null
     */
    public ?string $name;

    /**
     * @var string|null
     */
    public ?string $file_name;

    /**
     * @var int|null
     */
    public ?int $order_column;

    /**
     * @var \Illuminate\Http\UploadedFile|null
     */
    public ?UploadedFile $file;
}
