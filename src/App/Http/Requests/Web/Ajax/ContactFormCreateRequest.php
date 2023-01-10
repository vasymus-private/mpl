<?php

namespace App\Http\Requests\Web\Ajax;

use App\Constants;
use Domain\Users\Models\ContactForm;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Support\H;

/**
 * @property string|null $name
 * @property string $email
 * @property string|null $phone
 * @property string $description
 * @property \Symfony\Component\HttpFoundation\File\UploadedFile[]|null $files
 * @property int|string $type
 */
class ContactFormCreateRequest extends FormRequest
{
    protected const MIME_TYPES = [
        Constants::MIME_JPEG,
        Constants::MIME_GIF,
        Constants::MIME_PNG,
        Constants::MIME_HTML,
        Constants::MIME_PDF,
        Constants::MIME_DOCX,
        Constants::MIME_DOC,
        Constants::MIME_PPTX,
        Constants::MIME_PPT,
        Constants::MIME_XLSX,
        Constants::MIME_XLS,
        Constants::MIME_ZIP,
        Constants::MIME_VIDEO_AVI,
        Constants::MIME_VIDEO_MPEG,
        Constants::MIME_VIDEO_QUICKTIME,
    ];

    protected const TYPES = [
        ContactForm::TYPE_QUESTION,
        ContactForm::TYPE_CONTACT,
        ContactForm::TYPE_REQUEST_TECHNOLOGIST,
    ];

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
            'name' => [
                'nullable',
                'string',
                'max:250',
            ],
            'email' => [
                'required',
                'email',
                'max:250',
            ],
            'phone' => [
                'nullable',
                'string',
                'max:250',
            ],
            'description' => [
                'required',
                'nullable',
                'string',
                'max:65000',
            ],
            'files' => 'nullable|array|max:3',
            'files.*' => sprintf('mimetypes:%s|max:%s', implode(',', static::MIME_TYPES), H::validatorMb(5)),
            'type' => sprintf('required|in:%s', implode(',', static::TYPES)),
            'captcha' => 'required|captcha',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if ((int)$this->type === ContactForm::TYPE_REQUEST_TECHNOLOGIST) {
            session()->flash('failedRequestTechnologist', 1);
        }

        parent::failedValidation($validator);
    }
}
