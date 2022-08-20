<?php

namespace App\Http\Requests\Admin\Ajax;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    use HasCreateUpdateProductRequest;
}
