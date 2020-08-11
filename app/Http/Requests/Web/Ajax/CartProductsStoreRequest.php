<?php

namespace App\Http\Requests\Web\Ajax;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class CartProductsStoreRequest extends FormRequest
{
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
            $existsIds = Product
                ::query()
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
                ->active()
                ->pluck("id")
                ->toArray()
            ;
            if (!in_array($this->id, $existsIds)) {
                $validator->errors()->add("id", "Id `{$this->id}` of product should exist, be active and be a variation or product without variations.");
            }
        });
    }
}
