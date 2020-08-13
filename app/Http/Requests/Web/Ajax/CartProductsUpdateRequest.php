<?php

namespace App\Http\Requests\Web\Ajax;

use App\Models\Product\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class CartProductsUpdateRequest extends FormRequest
{
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
