<?php

namespace Domain\GalleryItems\QueryBuilders;

use Domain\GalleryItems\Models\GalleryItem;
use Illuminate\Database\Eloquent\Builder;

/**
 * @template TModelClass of \Domain\GalleryItems\Models\GalleryItem
 * @extends Builder<TModelClass>
 *
 * @method \Domain\GalleryItems\Models\GalleryItem|null first($columns = ['*'])
 * @method \Domain\GalleryItems\Models\GalleryItem findOrFail($id, $columns = ['*'])
 * @method \Domain\GalleryItems\Models\GalleryItem firstOrFail($columns = ['*'])
 * @method \Illuminate\Database\Eloquent\Collection<\Domain\GalleryItems\Models\GalleryItem> get($columns = ['*'])
 */
class GalleryItemQueryBuilder extends Builder
{
    /**
     * @var string
     */
    protected string $table = GalleryItem::TABLE;

    /**
     * @return self
     */
    public function parents(): self
    {
        return $this->whereNull(sprintf('%s.parent_id', $this->table));
    }

    /**
     * @return self
     */
    public function active(): self
    {
        return $this->where(sprintf('%s.is_active', $this->table), true);
    }
}
