<?php

namespace App\Http\Requests\API\Project;

use App\Traits\Response\ResponseHandlingTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ProjectCreateRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    final public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'departments_id' => 'required|integer|exists:departments,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'project_statuses_id' => 'required|integer|exists:project_statuses,id',
        ];
    }

    final public function failedValidation(Validator $validator): void
    {
        $this->returnValidationErrors($validator->errors());
    }
}
