<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            //
            'product_name'  => ['required', Rule::unique('products', 'product_name')->whereNull('deleted_at')],
            'product_price' => 'required|numeric|min:0',
            //'product_unit'  => 'required'
        ];
    }
}
