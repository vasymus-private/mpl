<?php

namespace App\Http\Requests\Admin\Ajax;

use Domain\Users\DTOs\BlacklistDTO;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string|null $ip
 * @property-read string|null $email
 */
class CreateUpdateBlacklistRequest extends FormRequest
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
            'ip' => 'nullable|string|max:250',
            'email' => 'nullable|string|max:250',
        ];
    }

    /**
     * @return \Domain\Users\DTOs\BlacklistDTO
     */
    public function prepare(): BlacklistDTO
    {
        $payload = $this->all();

        return new BlacklistDTO([
            'ip' => isset($payload['ip'])
                ? (string)$payload['ip']
                : null,
            'email' => isset($payload['email'])
                ? (string)$payload['email']
                : null,
        ]);
    }
}
