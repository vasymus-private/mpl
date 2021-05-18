<?php

namespace Domain\Common\DTOs;

use Domain\Common\Models\CustomMedia;
use Livewire\TemporaryUploadedFile;
use Spatie\DataTransferObject\DataTransferObject;
use Support\H;

class FileDTO extends DataTransferObject
{
    protected bool $ignoreMissing = true;

    public ?int $id;

    public ?string $mime_type;

    public ?string $mime_type_name;

    public ?string $name;

    public ?string $file_name;

    public ?string $path;

    public static function fromCustomMedia(CustomMedia $media): self
    {
        return new self([
            "id" => $media->id,
            "mime_type" => $media->mime_type,
            "mime_type_name" => $media->mime_type_name,
            "file_name" => $media->file_name,
            "name" => $media->name,
            "path" => $media->getUrl(),
        ]);
    }

    public static function fromTemporaryUploadedFile(TemporaryUploadedFile $temporaryUploadedFile): self
    {
        return new self([
            "id" => null,
            "mime_type" => $temporaryUploadedFile->getMimeType(),
            "mime_type_name" => H::getMimeTypeName($temporaryUploadedFile->getMimeType()),
            "file_name" => $temporaryUploadedFile->getClientOriginalName(),
            "name" => null,
            "path" => $temporaryUploadedFile->temporaryUrl(),
        ]);
    }
}
