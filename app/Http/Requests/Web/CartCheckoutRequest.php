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
            "name" => "string|required|max:199",
            "email" => "string|required|email|max:199",
            "phone" => "alpha_num|required|max:199",
            "comment" => "string|nullable|max:199",
            "attachment" => "array|nullable",
            "attachment.*" => "file|max:10000", // TODO validations via mymetypes предполагается, что что-то типа файла с реквизитами (ексель, пдф, фото реквизитов) !!! может несколько файлов // ВОЗМОЖНО ПРОДУМАТЬ КАКОЙ-ТО общий размер файлов с какого-то ip адреса
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function(Validator $validator) {
            /** @var User $user */
            $user = Auth::user();
            if ($user->cart->pivotNotTrashed()->isEmpty()) {
                $validator->errors()->add("cart", "У вас пустая корзина.");
            }
        });
    }
}
