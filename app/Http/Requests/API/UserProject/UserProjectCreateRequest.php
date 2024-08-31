<?php

namespace App\Http\Requests\API\UserProject;

use App\Traits\Response\ResponseHandlingTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UserProjectCreateRequest extends FormRequest
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
            'user_id' => 'required|integer|exists:users,id',
            'project_id' => 'required|integer|exists:projects,id',
        ];
    }

    final public function failedValidation(Validator $validator): void
    {
        $this->returnValidationErrors($validator->errors());
    }
}
