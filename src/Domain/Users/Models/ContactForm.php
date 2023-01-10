<?php

namespace Domain\Users\Models;

use App\Providers\MediaLibraryServiceProvider;
use Domain\Common\Models\BaseModel;
use Domain\Ip\Models\Ip;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $id
 * @property string|null $uuid
 * @property int $type
 * @property string|null $ip
 * @property string|null $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @see \Domain\Users\Models\ContactForm::ipDetails()
 * @property \Domain\Ip\Models\Ip|null $ipDetails
 *
 * @see \Domain\Users\Models\ContactForm::getTypeNameAttribute()
 * @property string|null $type_name
 */
class ContactForm extends BaseModel implements HasMedia
{
    use InteractsWithMedia;

    public const TABLE = 'contact_forms';

    /**
     * The name of the "updated at" column.
     *
     * @var string|null
     */
    public const UPDATED_AT = null;

    public const TYPE_QUESTION = 1;
    public const TYPE_CONTACT = 2;
    public const TYPE_REQUEST_TECHNOLOGIST = 3;

    public const MC_FILES = "files";

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * @inheritDoc
     */
    protected static function boot()
    {
        parent::boot();

        $cb = function (self $model) {
            if (! $model->uuid) {
                $model->uuid = (string) Str::uuid();
            }
        };

        static::saving($cb);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ipDetails(): BelongsTo
    {
        return $this->belongsTo(Ip::class, "ip", "ip");
    }

    /**
     * @return string|null
     */
    public function getTypeNameAttribute(): ?string
    {
        switch ($this->type) {
            case static::TYPE_QUESTION: {
                return 'Задать вопрос';
            }
            case static::TYPE_CONTACT: {
                return 'Отправить контакт';
            }
            case static::TYPE_REQUEST_TECHNOLOGIST: {
                return 'Связаться с технологом';
            }
            default: {
                return '';
            }
        }
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection(static::MC_FILES)
            ->useDisk(MediaLibraryServiceProvider::getPrivateMediaDisk());
    }

    public static function rbAdminContactForm($value)
    {
        return static::query()->findOrFail($value);
    }
}
