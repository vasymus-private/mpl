<?php

namespace App\Http\Requests\Admin\Ajax;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    use HasCreateUpdateProductRequest;
}
