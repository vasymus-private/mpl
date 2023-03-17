<?php

namespace Domain\Users\Models;

use App\Providers\MediaLibraryServiceProvider;
use Domain\Common\Models\BaseModel;
use Domain\Ip\Models\Ip;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

/**
 * @property int $id
 * @property string|null $uuid
 * @property int $type
 * @property string|null $ip
 * @property string|null $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $description
 * @property array $meta
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @see \Domain\Users\Models\ContactForm::ipDetails()
 * @property \Domain\Ip\Models\Ip|null $ipDetails
 *
 * @see \Domain\Users\Models\ContactForm::getTypeNameAttribute()
 * @property string|null $type_name
 *
 * @see \Domain\Users\Models\ContactForm::getFilesAttribute()
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $files
 *
 * @see \Domain\Users\Models\ContactForm::getReadByAdminIdAttribute()
 * @see \Domain\Users\Models\ContactForm::setReadByAdminIdAttribute()
 * @property int|null $read_by_admin_id
 *
 * @see \Domain\Users\Models\ContactForm::getReadByAdminAtAttribute()
 * @see \Domain\Users\Models\ContactForm::setReadByAdminAtAttribute()
 * @property \Illuminate\Support\Carbon|\Carbon\Carbon|null $read_by_admin_at
 *
 * @see \Domain\Users\Models\ContactForm::getIsReadByAdminAttribute()
 * @property-read bool $is_read_by_admin
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

    protected const META_KEY_READ_BY_ADMIN_ID = 'read_by_admin_id';
    protected const META_KEY_READ_BY_ADMIN_AT = 'read_by_admin_at';

    protected const META_DATE_FORMAT = 'Y-m-d H:i:s';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'meta' => 'array',
    ];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'meta' => '[]',
    ];

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
        /** @var \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Database\Eloquent\Builder $ipQuery */
        $ipQuery = $this->belongsTo(Ip::class, "ip", "ip");
        $ipQuery->withCount('blacklist');

        return $ipQuery;
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

    /**
     * @return \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<array-key, \Domain\Common\Models\CustomMedia>
     */
    public function getFilesAttribute(): MediaCollection
    {
        return $this->getMedia(static::MC_FILES);
    }

    /**
     * @return int|null
     */
    public function getReadByAdminIdAttribute(): ?int
    {
        $meta = is_array($this->meta) ? $this->meta : [];

        return isset($meta[static::META_KEY_READ_BY_ADMIN_ID]) ? (int)$meta[static::META_KEY_READ_BY_ADMIN_ID] : null;
    }

    /**
     * @param int|null $id
     *
     * @return void
     */
    public function setReadByAdminIdAttribute(?int $id = null): void
    {
        $meta = is_array($this->meta) ? $this->meta : [];

        $meta[static::META_KEY_READ_BY_ADMIN_ID] = $id;

        $this->meta = $meta;
    }

    /**
     * @return \Illuminate\Support\Carbon|\Carbon\Carbon|null
     */
    public function getReadByAdminAtAttribute(): Carbon|\Carbon\Carbon|null
    {
        $meta = is_array($this->meta) ? $this->meta : [];

        $readByAdminAt = isset($meta[static::META_KEY_READ_BY_ADMIN_AT]) ? (string)$meta[static::META_KEY_READ_BY_ADMIN_AT] : null;
        if (!$readByAdminAt) {
            return null;
        }

        $date = Carbon::createFromFormat(static::META_DATE_FORMAT, $readByAdminAt);

        return $date ?: null;
    }

    /**
     * @param \Illuminate\Support\Carbon|\Carbon\Carbon|null $date
     *
     * @return void
     */
    public function setReadByAdminAtAttribute(Carbon|\Carbon\Carbon|null $date): void
    {
        $meta = is_array($this->meta) ? $this->meta : [];

        $meta[static::META_KEY_READ_BY_ADMIN_ID] = $date;

        $this->meta = $meta;
    }

    /**
     * @return bool
     */
    public function getIsReadByAdminAttribute(): bool
    {
        return !empty($this->read_by_admin_id);
    }
}
