<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{

    /**
     * Force response json type when validation fails
     * @var bool
     */

    protected $forceJsonResponse = true;
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
            'invoice_item'  => 'required|array',
            'invoice_item.*' => 'required',
            'invoice_item.*.name' => 'required|exists:products,product_name',
            'invoice_item.*.value' => 'required|numeric|exists:products,id',
            'invoice_item.*.total' => 'required|numeric',
            'invoice_tax'   => 'sometimes|required|array',
            'invoice_tax.*' => 'sometimes|required',
            'invoice_tax.*.name' => 'sometimes|required',
            'invoice_tax.*.total' => 'sometimes|required_with:invoice_tax.*.name',
            'invoice_notes' => 'nullable'
        ];
    }
}