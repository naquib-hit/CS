<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreInvoiceRequest extends FormRequest
{

    /**
     * Force response json type when validation fails
     * @var bool
     */

    //protected $forceJsonResponse = false;
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
            'invoice_no' => 'required|unique:invoices,invoice_no',
            'invoice_customer_text' => 'required|exists:customers,customer_name',
            'invoice_customer' => 'required|exists:customers,id',
            'invoice_date'  => ['required', 'date'],
            'invoice_due'   => 'required|date|after_or_equal:invoice_date',
            'invoice_discount' => 'nullable',
            'invoice_items'  => 'required|array',
            'invoice_items.*' => 'required',
            'invoice_items.*.name' => 'required|string|exists:products,product_name',
            'invoice_items.*.value' => 'required|numeric|exists:products,id',
            'invoice_items.*.total' => 'required|numeric',
            'invoice_tax'   => 'sometimes|required|array',
            'invoice_tax.*' => 'sometimes|required',
            'invoice_tax.*.name' => 'sometimes|required',
            'invoice_tax.*.total' => 'sometimes|required_with:invoice_tax.*.name',
            'invoice_notes' => 'nullable'
        ];
    }

    // /**
    //  * Handle a failed validation attempt.
    //  *
    //  * @param  \Illuminate\Contracts\Validation\Validator  $validator
    //  * @return void
    //  *
    //  * @throws \Illuminate\Validation\ValidationException
    //  */
    // protected function failedValidation(\Illuminate\Contracts\Validation\Validator  $validator)
    // {
    //     throw new ValidationException(response()->json([
    //         'success' => false,
    //         'message' => __('validation.failed.create'),
    //         'errors'  => $validator->errors()
    //     ], 422, [
    //         'Content-Type' => 'application/json'
    //     ]));
    // }
}