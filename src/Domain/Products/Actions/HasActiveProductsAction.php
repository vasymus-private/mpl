<?php

namespace Domain\Products\Actions;

use Domain\Products\Models\Category;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class HasActiveProductsAction
{
    /**
     * @param string|int $id
     *
     * @return bool
     */
    public function execute($id): bool
    {
//         select c1.id, c1.name,
//         count(c2.id), count(c3.id), count(p1.id),
//         GROUP_CONCAT(DISTINCT c2.id SEPARATOR ', ') as c2,
//         GROUP_CONCAT(DISTINCT c3.id SEPARATOR ', ') as c3,
//         GROUP_CONCAT(DISTINCT p1.id SEPARATOR ', ') as p
//         from categories as c1
//         left join categories as c2 on c1.id = c2.parent_id and c2.deleted_at is null
//         left join categories as c3 on c2.id = c3.parent_id and c3.deleted_at is null
//         left join products as p1 on p1.category_id in (c1.id, c2.id, c3.id) and p1.deleted_at is null and p1.is_active = 1
//         where c1.parent_id is null
//         group by c1.id
        $categoryT = Category::TABLE;
        $subcategory1Alias = "c2";
        $subcategory2Alias = "c3";
        $productT = Product::TABLE;
        $productAlias = "p1";

        return Category
            ::query()
            ->select("$categoryT.id")
            ->leftJoin("$categoryT as $subcategory1Alias", function(JoinClause $query) use($categoryT, $subcategory1Alias) {
                $query->on("$categoryT.id", "=", "$subcategory1Alias.parent_id")
                    ->whereNull("$subcategory1Alias.deleted_at");
            })
            ->leftJoin("$categoryT as $subcategory2Alias", function(JoinClause $query) use($categoryT, $subcategory1Alias, $subcategory2Alias) {
                $query->on("$subcategory1Alias.id", "=", "$subcategory2Alias.parent_id")
                    ->whereNull("$subcategory2Alias.deleted_at");
            })
            ->join("$productT as $productAlias", function(JoinClause $query) use($categoryT, $subcategory1Alias, $subcategory2Alias, $productAlias) {
                $query->whereRaw(
                    DB::raw("$productAlias.category_id in (`$categoryT`.`id`, `$subcategory1Alias`.`id`, `$subcategory2Alias`.`id`)")
                )
                    ->where("$productAlias.is_active", true)
                    ->whereNull("$productAlias.deleted_at");
            })
            ->where("$categoryT.id", $id)
            ->exists();
    }
}
