<?php

namespace Domain\Articles\Actions;

use Domain\Articles\DTOs\ArticleDTO;
use Domain\Articles\Models\Article;
use Domain\Common\Actions\BaseAction;
use Domain\Common\Actions\SaveSeoAction;
use Illuminate\Support\Facades\DB;

class CreateOrUpdateArticleAction extends BaseAction
{
    /**
     * @var \Domain\Common\Actions\SaveSeoAction
     */
    private SaveSeoAction $saveSeoAction;

    /**
     * @param \Domain\Common\Actions\SaveSeoAction $saveSeoAction
     */
    public function __construct(SaveSeoAction $saveSeoAction)
    {
        $this->saveSeoAction = $saveSeoAction;
    }

    /**
     * @param \Domain\Articles\DTOs\ArticleDTO $articleDTO
     * @param \Domain\Articles\Models\Article|null $target
     *
     * @return \Domain\Articles\Models\Article
     */
    public function execute(ArticleDTO $articleDTO, Article $target = null): Article
    {
        return DB::transaction(function () use ($articleDTO, $target) {
            $target = $target ?: new Article();

            if ($articleDTO->name !== null) {
                $target->name = $articleDTO->name;
            }

            if ($articleDTO->slug !== null) {
                $target->slug = $articleDTO->slug;
            }

            if ($articleDTO->is_active !== null) {
                $target->is_active = $articleDTO->is_active;
            }

            if ($articleDTO->parent_id !== null) {
                $target->parent_id = $articleDTO->parent_id !== 0 ? $articleDTO->parent_id : null;
            }

            if ($articleDTO->description !== null) {
                $target->description = $articleDTO->description;
            }

            if (! $target->id) {
                $target->save();
            }

            $this->saveSeoAction->execute($target, $articleDTO->seo);

            $target->save();

            return $target;
        });
    }
}
