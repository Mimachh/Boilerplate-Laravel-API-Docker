<?php

namespace App\Http\Requests\Admin\Category;

use App\Enums\CategoryStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('update', $this->category);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required|string|max:60|unique:categories,name",
            "slug" => "required|string|max:60|unique:categories,slug",
            "description" => "nullable|string|max:255",
            "titleSEO" => "nullable|string|max:60",
            "descriptionSEO" => "nullable|string|max:160",
            "keywordsSEO" => "nullable|string|max:255",
            "status" => ["required", Rule::in(array_column(CategoryStatus::cases(), 'value'))]
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'error'   => true,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ], 422));
    }
}
