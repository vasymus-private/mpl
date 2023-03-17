<?php

namespace App\Http\Requests\Admin\Ajax;

use Domain\Users\Models\ContactForm;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read array[] $ids
 * @property-read bool $isRead
 */
class ContactFormsBulkReadStateRequest extends FormRequest
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
            'ids' => 'required|array',
            'ids.*' => sprintf('exists:%s,id', ContactForm::class),
            'isRead' => 'required|bool',
        ];
    }
}
