<?php

namespace App\Providers;

use App\Constants;
use Spatie\MediaLibrary\MediaLibraryServiceProvider as BaseMediaLibraryServiceProvider;

class MediaLibraryServiceProvider extends BaseMediaLibraryServiceProvider
{
    /**
     * @return string
     */
    public static function getDiskName(): string
    {
        return static::getPublicMediaDisk();
    }

    /**
     * @return string
     */
    public static function getPublicMediaDisk(): string
    {
        return config('services.media-library.mediaDiscIsCloud') ? Constants::MEDIA_DISK_S3_PUBLIC : Constants::MEDIA_DISK_PUBLIC;
    }

    /**
     * @return string
     */
    public static function getPrivateMediaDisk(): string
    {
        return config('services.media-library.mediaDiscIsCloud') ? Constants::MEDIA_DISK_S3_PRIVATE : Constants::MEDIA_DISK_PRIVATE;
    }
}
