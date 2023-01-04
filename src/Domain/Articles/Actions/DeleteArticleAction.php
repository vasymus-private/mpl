<?php

namespace Domain\Articles\Actions;

use Domain\Articles\Models\Article;
use Domain\Common\Actions\BaseAction;
use Illuminate\Support\Facades\DB;

class DeleteArticleAction extends BaseAction
{
    /**
     * @param \Domain\Articles\Models\Article $article
     *
     * @return void
     */
    public function execute(Article $article): void
    {
        DB::transaction(function () use ($article) {
            $article->children()->get()->each(function (Article $a) {
                $a->parent_id = null;
                $a->save();
            });

            $article->delete();
        });
    }
}
