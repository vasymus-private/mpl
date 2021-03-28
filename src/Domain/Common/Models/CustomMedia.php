<?php

namespace Domain\Common\Models;

use App\Constants;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property int $id
 * @property string $model_type
 * @property int $model_id
 * @property string|null $uuid
 * @property string $collection_name
 * @property string $name
 * @property string $file_name
 * @property string|null $mime_type
 * @property string $disk
 * @property string $conversions_disk
 * @property int $size
 * @property array $manipulations
 * @property array $custom_properties
 * @property array $generated_conversions
 * @property array $responsive_images
 * @property int|null $order_column
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 *
 * @see \Domain\Common\Models\CustomMedia::getMimeTypeNameAttribute()
 * @property-read string $mime_type_name
 */
class CustomMedia extends Media
{
    public function getMimeTypeNameAttribute(): string
    {
        switch ($this->mime_type) {
            case Constants::MIME_DOC :
            case Constants::MIME_DOCX : {
                return "MS Word";
            }
            case Constants::MIME_PPT :
            case Constants::MIME_PPTX : {
                return "MS PowerPoint";
            }
            case Constants::MIME_XLS :
            case Constants::MIME_XLSX : {
                return "MS Excel";
            }
            case Constants::MIME_GIF : {
                return "gif";
            }
            case Constants::MIME_JPEG : {
                return "jpeg";
            }
            case Constants::MIME_PNG : {
                return "png";
            }
            case Constants::MIME_HTML : {
                return "html";
            }
            case Constants::MIME_PDF : {
                return "pdf";
            }
            default : {
                return "";
            }
        }
    }
}
