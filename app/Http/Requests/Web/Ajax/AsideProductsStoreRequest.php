<?php

namespace App\Http\Requests\Web\Ajax;

use App\Models\Product\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class AsideProductsStoreRequest extends FormRequest
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
            "ids" => "required|array",
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
            $existsIds = Product::query()->notVariation()->active()->pluck("id")->toArray();
            foreach ($this->ids as $id) {
                if (!in_array($id, $existsIds)) {
                    $validator->errors()->add("id", "Id `$id` of product should exist, be active and not be a variation.");
                }
            }
        });
    }
}
