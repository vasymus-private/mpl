<?php

namespace Domain\Users\Models;

use App\Providers\MediaLibraryServiceProvider;
use Domain\Common\Models\BaseModel;
use Domain\Ip\Models\Ip;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $id
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
    public const TYPE_REQUEST_TECHNOLOGIES = 3;

    public const MC_FILES = "files";

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

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
    public function getTypeNameAttribute():? string
    {
        switch ($this->type) {
            case static::TYPE_QUESTION: {
                return 'вопрос';
            }
            case static::TYPE_CONTACT: {
                return 'контакт';
            }
            case static::TYPE_REQUEST_TECHNOLOGIES: {
                return 'технолог';
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
}
