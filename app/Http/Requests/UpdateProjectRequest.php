<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
            'project_name'      => ['required', Rule::unique('projects')->where(fn ($q) => $q->where('id', '<>', $id))->whereNull('deleted_at')],
            'project_customer'  => ['required', 'exists:customers,id']
        ];
    }
}
