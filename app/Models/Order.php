<?php

namespace App\Models;

use App\Models\Pivots\OrderProduct;
use App\Models\Product\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property float $price_retail
 * @property int $order_status_id
 * @property int $user_id
 * @property int $manager_id
 * @property int $importance_id
 * @property int $customer_bill_status_id
 * @property string|null $customer_bill_description
 * @property int $provider_bill_status_id
 * @property string|null $provider_bill_description
 * @property string|null $comment_user
 * @property string|null $comment_manager
 * @property string|null $ps_status
 * @property string|null $ps_description
 * @property float|null $ps_amount
 * @property Carbon|null $ps_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @see Order::products()
 * @property Collection|Product[] $products
 * */
class Order extends BaseModel
{
    use SoftDeletes;

    const TABLE = "orders";

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ["ps_date"];

    public function products(): BelongsToMany
    {
        return $this
            ->belongsToMany(Product::class, OrderProduct::TABLE, "order_id", "product_id")
            ->using(OrderProduct::class)
            ->withPivot([
                "count",
                "price_purchase",
                "price_retail",
                "name",
            ])
        ;
    }
}
