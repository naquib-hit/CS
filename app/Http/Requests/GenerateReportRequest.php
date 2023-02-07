<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateReportRequest extends FormRequest
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
            'selected_by'   => 'required',
            'periode_from'  => 'required|date',
            'periode_to'    => 'required|date|after_or_equal:periode_from',
            'file_type'     => 'required|in:pdf,excel,csv'
        ];
    }
}
