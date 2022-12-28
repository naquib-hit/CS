<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSalesRequest extends FormRequest
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
            'sales_code'    => ['required', Rule::unique('sales', 'sales_code')->whereNull('deleted_at')],
            'sales_name'    => 'required',
            'sales_email'   => ['required', Rule::unique('sales', 'sales_email')->whereNull('deleted_at')],
        ];
    }
}
