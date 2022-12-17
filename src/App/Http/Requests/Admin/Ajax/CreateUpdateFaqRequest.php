<?php

namespace App\Http\Requests\Admin\Ajax;

use Domain\FAQs\DTOs\FaqDTO;
use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateFaqRequest extends FormRequest
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
        return [];
    }

    /**
     * @return \Domain\FAQs\DTOs\FaqDTO
     */
    public function prepare(): FaqDTO
    {
        return new FaqDTO();
    }
}
