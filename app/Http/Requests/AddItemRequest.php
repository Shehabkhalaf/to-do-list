<?php

namespace App\Http\Requests;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class AddItemRequest extends FormRequest
{
    //ApiResponse trait to use jsonResponse
    use ApiResponse;

    /**
     * Determine if the user is authorized to make this request.
     * @throws ValidationException
     */
    public function failedValidation(Validator $validator): void
    {
        if ($this->is('api/*')) {
            $response = $this->JsonResponse(422, 'Validation Errors', $validator->errors());
            throw new ValidationException($validator, $response);
        }
    }
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    //The rules applied to the request
    public function rules(): array
    {
        return [
            'description' => 'required',
        ];
    }

    //Function to return the error messages
    public function messages(): array
    {
        return[
            'description.required' => 'Description field is required.',
        ];
    }
}
