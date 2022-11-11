<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotebookStoreRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'fio' => 'required|max:200',
            'company' => 'max:200',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'birthday' => 'date',
            'photo' => 'max:350',
        ];
    }
}
