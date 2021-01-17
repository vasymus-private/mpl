<?php

namespace App\Http\Requests\Web;

use App\Models\User\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

/**
 * @property-read string $name
 * @property-read string $email
 * @property-read string $phone
 * @property-read string $comment
 * @property-read UploadedFile[]|null attachment
 * */
class CartCheckoutRequest extends FormRequest
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
            "name" => "string|nullable|max:199",
            "email" => "string|nullable|email|max:199",
            "phone" => "alpha_num|nullable|max:199",
            "comment" => "string|nullable|max:199",
            "attachment" => "array|nullable",
            "attachment.*" => "file|max:10000", // TODO validations via mymetypes предполагается, что что-то типа файла с реквизитами (ексель, пдф, фото реквизитов) !!! может несколько файлов // ВОЗМОЖНО ПРОДУМАТЬ КАКОЙ-ТО общий размер файлов с какого-то ip адреса
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function(Validator $validator) {
            $this->validateCartNotEmpty();
            if ($this->getAuthUser()->is_anonymous2) {
                $this->validateAnonymous();
            }
        });
    }

    protected function validateCartNotEmpty()
    {
        if ($this->getAuthUser()->cart_not_trashed->isEmpty()) {
            $this->getValidatorInstance()->errors()->add("cart", "У вас пустая корзина.");
        }
    }

    protected function validateAnonymous()
    {
        if (empty($this->email)) {
            $this->getValidatorInstance()->errors()->add("email", "E-mail поле обязательно.");
        }
        if (empty($this->name)) {
            $this->getValidatorInstance()->errors()->add("name", "Имя обязательно.");
        }
        if (empty($this->phone)) {
            $this->getValidatorInstance()->errors()->add("phone", "Телефон обязателен.");
        }
    }

    protected function getAuthUser(): User
    {
        return Auth::user();
    }
}
