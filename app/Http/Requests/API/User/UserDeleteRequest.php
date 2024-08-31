<?php

namespace App\Http\Requests\API\User;

use App\Traits\Response\ResponseHandlingTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UserDeleteRequest extends FormRequest
{
    use ResponseHandlingTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    final public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    final public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:users,id',
        ];
    }

    final public function failedValidation(Validator $validator): void
    {
        $this->returnValidationErrors($validator->errors());
    }
}
