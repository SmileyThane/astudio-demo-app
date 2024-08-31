<?php

namespace App\Http\Requests\API\Project;

use App\Traits\Response\ResponseHandlingTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ProjectUpdateRequest extends FormRequest
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
            'id' => 'required|integer|exists:projects,id',
            'name' => 'sometimes|string|max:255',
            'departments_id' => 'sometimes|integer|exists:departments,id',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date',
            'project_statuses_id' => 'sometimes|integer|exists:project_statuses,id',
        ];
    }

    final public function failedValidation(Validator $validator): void
    {
        $this->returnValidationErrors($validator->errors());
    }
}
