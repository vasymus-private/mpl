<?php

namespace App\Http\Requests\Admin\Ajax;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @mixin \App\Http\Requests\Admin\Ajax\HasCreateUpdateProductRequest
 */
class UpdateProductRequest extends FormRequest
{
    use HasCreateUpdateProductRequest;
}
