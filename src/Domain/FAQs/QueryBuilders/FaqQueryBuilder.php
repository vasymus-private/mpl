<?php

namespace Domain\FAQs\QueryBuilders;

use Domain\FAQs\Models\FAQ;
use Illuminate\Database\Eloquent\Builder;

/**
 * @template TModelClass of \Domain\FAQs\Models\FAQ
 * @extends Builder<TModelClass>
 */
class FaqQueryBuilder extends Builder
{
    /**
     * @return self
     */
    public function parents(): self
    {
        return $this->whereNull(sprintf('%s.parent_id', FAQ::TABLE));
    }

    /**
     * @return self
     */
    public function active(): self
    {
        return $this->where(sprintf('%s.is_active', FAQ::TABLE), true);
    }
}
