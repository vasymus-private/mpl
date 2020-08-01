<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Admin extends User implements HasMedia
{
    use HasMediaTrait;

    const ID_CENTRAL_ADMIN = 1;

    const MC_COMMON_MEDIA = "common-media"; // use as walkaround to many-to-one of spatie/medialibrary @see https://github.com/spatie/laravel-medialibrary/issues/1215#issuecomment-415555175

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope("admin", function(Builder $builder) {
            $builder->where(static::TABLE . ".status", ">=", static::ADMIN_THRESHOLD);
        });
    }

    public static function firstOrCreateAnonymous(string $anonymousUid): User
    {
        throw new \LogicException("Can not create anonymous admin");
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection(static::MC_COMMON_MEDIA);
    }
}
