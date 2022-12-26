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
            'customer_phone'    => ['required', 'numeric', Rule::unique('customers', 'customer_phone')->whereNull('deleted_at')]
        ];
    }
}
