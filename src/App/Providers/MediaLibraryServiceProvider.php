<?php

namespace App\Providers;

use App\Constants;
use Spatie\MediaLibrary\MediaLibraryServiceProvider as BaseMediaLibraryServiceProvider;

class MediaLibraryServiceProvider extends BaseMediaLibraryServiceProvider
{
    /**
     * @return string
     */
    public static function getPublicMediaDisk(): string
    {
        return config('media-library.media_disc_is_cloud') ? Constants::MEDIA_DISK_S3_PUBLIC : Constants::MEDIA_DISK_PUBLIC;
    }

    /**
     * @return string
     */
    public static function getPrivateMediaDisk(): string
    {
        return config('media-library.media_disc_is_cloud') ? Constants::MEDIA_DISK_S3_PRIVATE : Constants::MEDIA_DISK_PRIVATE;
    }
}
