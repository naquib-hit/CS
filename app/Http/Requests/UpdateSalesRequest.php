<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSalesRequest extends FormRequest
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
        $uri = explode('/', $this->path());
        $id = $uri[count($uri) - 1];
        return [
            //
            'sales_code'    => ['required', Rule::unique('sales', 'sales_code')->where(fn ($q) => $q->where('id', '<>', $id))],
            'sales_name'    => 'required',
            'sales_email'   => ['required', Rule::unique('sales', 'sales_email')->where(fn ($q) => $q->where('id', '<>', $id))->whereNull('deleted_at')],
        ];
    }
}
