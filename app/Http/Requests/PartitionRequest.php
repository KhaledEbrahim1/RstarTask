<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartitionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name_en' => ['required','unique:partitions,name_en','max:255'],
            'name_ar' => ['required','unique:partitions,ar','max:255'],
            'cat_id' => 'required',

        ];
    }
}
