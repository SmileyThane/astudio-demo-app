<?php

namespace App\Http\Requests\API\Timesheet;

use App\Traits\Response\ResponseHandlingTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class TimesheetUpdateRequest extends FormRequest
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
            'id' => 'required|integer|exists:timesheets,id',
            'user_projects_id' => 'prohibited',
            'user_id' => 'prohibited',
            'project_id' => 'prohibited',
            'title' => 'sometimes|string|max:255',
            'date' => 'sometimes|date|date_format:Y-m-d',
            'spent_hours' => 'sometimes|integer',
        ];
    }

    final public function failedValidation(Validator $validator): void
    {
        $this->returnValidationErrors($validator->errors());
    }
}
