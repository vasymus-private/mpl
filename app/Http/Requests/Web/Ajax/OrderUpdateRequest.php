<?php

namespace App\Http\Requests\Web\Ajax;

use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\User\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * @property-read int $order_id
 * @property-read int $payment_method_id
 * @property-read string|null $payment_method_description
 * @property-read UploadedFile[]|null attachment
 * */
class OrderUpdateRequest extends FormRequest
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
            "order_id" => [
                "required",
                Rule::exists(Order::TABLE, "id")->where("user_id", $this->getAuthUser()->id)
            ],
            "payment_method_id" => "required|exists:" . PaymentMethod::class . ",id",
            "payment_method_description" => "string|nullable|max:1000",
            "attachment" => "array|nullable",
            "attachment.*" => "file|max:10000", // TODO validations via mymetypes предполагается, что что-то типа файла с реквизитами (ексель, пдф, фото реквизитов) !!! может несколько файлов // ВОЗМОЖНО ПРОДУМАТЬ КАКОЙ-ТО общий размер файлов с какого-то ip адреса
        ];
    }

    protected function getAuthUser(): User
    {
        return Auth::user();
    }
}
