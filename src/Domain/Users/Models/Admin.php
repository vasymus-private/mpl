<?php

namespace Domain\Users\Models;

use Domain\Users\Models\User\User;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Admin extends User implements HasMedia
{
    use InteractsWithMedia;

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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(static::MC_COMMON_MEDIA);
    }
}
