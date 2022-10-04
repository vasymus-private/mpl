<?php

namespace Domain\Common\DTOs;

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

    /**
     * @param array $media
     *
     * @return self
     */
    public static function create(array $media): self
    {
        return new self([
            'id' => isset($media['id']) ? (int)$media['id'] : null,
            'uuid' => isset($media['uuid']) ? (string)$media['uuid'] : null,
            'name' => isset($media['name']) ? (string)$media['name'] : null,
            'file_name' => isset($media['file_name']) ? (string)$media['file_name'] : null,
            'order_column' => isset($media['order_column']) ? (int)$media['order_column'] : null,
            'file' => $media['file'] ?? null,
        ]);
    }
}
