<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
            'customer_name'     => ['required', Rule::unique('customers')->whereNull('deleted_at')->where(fn ($q) => $q->where('id', '<>', $id))],
            'customer_email'    => ['required', 'email', Rule::unique('customers', 'customer_email')->whereNull('deleted_at')->where(fn ($q) => $q->where('id', '<>', $id))],
            'customer_phone'    => ['required', 'numeric', Rule::unique('customers', 'customer_phone')->whereNull('deleted_at')->where(fn ($q) => $q->where('id', '<>', $id))]
        ];
    }
}
