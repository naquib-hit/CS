<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
            'customer_name'     => ['required', Rule::unique('customers')->whereNull('deleted_at')],
            'customer_email'    => ['required', 'email', Rule::unique('customers', 'customer_email')->whereNull('deleted_at')],
            'customer_phone'    => ['required', 'regex:/^(\+62|62|^0)(8|9)?[\s-]?0?8[1-9]{1}\d{1}[\s-]?\d{4}[\s-]?\d{2,5}$/', Rule::unique('customers', 'customer_phone')->whereNull('deleted_at')]
        ];
    }
}
