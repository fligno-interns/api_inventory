<?php

namespace App\Http\Requests\Unit;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUnitRequest extends FormRequest
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
            'brand' => 'required',
            'model' => 'required',
            'serial' => 'required',
            'company_id' => 'required|exists:company,id',
            'category_id' => 'required|exists:category,id',
            'status_id' => 'exists:statuses,id',
        ];
    }
}
