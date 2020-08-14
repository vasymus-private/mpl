<?php

namespace App\Http\Requests\Web\Ajax;

use App\Models\Product\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

/**
 * @property int $id
 * @property int $count
 * @property string|null $updateCountMode
 * */
class CartProductsUpdateRequest extends FormRequest
{
    const MODE_ADD = "add";
    const MODE_NEW = "new";

    const MODE_DEFAULT = self::MODE_ADD;

    /**
     * @var Product
     * */
    protected $product;

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getCount(): int
    {
        $mode = $this->input("updateCountMode", CartProductsUpdateRequest::MODE_ADD);
        if ($mode === CartProductsUpdateRequest::MODE_ADD) {
            return $this->getProductCurrentCount() + $this->count;
        } else {
            return $this->count;
        }
    }

    protected function getProductCurrentCount(): int
    {
        return $this->product->pivot->count ?? 1;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "id" => "required|integer",
            "count" => "integer|min:1",
            "updateCountMode" => "in:" . static::MODE_ADD . "," . static::MODE_NEW,
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  Validator  $validator
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            /** @var User $user */
            $user = Auth::user();

            /** @var Product|Builder $productQuery */
            $productQuery = $user->cart();

            $productQuery
                ->active()
                ->available()
                ->where(function(Builder $query) {
                    $query
                        ->orWhere(function(Builder $qu) {
                            /** @var Product|Builder $qu*/
                            $qu->variations();
                        })
                        ->orWhere(function(Builder $qu) {
                            /** @var Product|Builder $qu*/
                            $qu->doesntHaveVariations();
                        })
                    ;
                })
            ;
            $this->product = $productQuery->find($this->id);
            if (!$this->product) {
                $validator->errors()->add("id", "Id `{$this->id}` of product should exist, be active, be available and be a variation or product without variations.");
            }
        });
    }


}
