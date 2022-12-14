<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'acronym' => 'required',
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'Name of the Company',
                'example' => 'Fligno AU',
            ],
            'acronym' => [
                'description' => 'Acronym of the Company',
                'example' => 'FAU',
            ],
        ];
    }
}
