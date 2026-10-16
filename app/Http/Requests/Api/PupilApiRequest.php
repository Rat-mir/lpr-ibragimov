<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PupilApiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $data = [];

        if ($this->has('schoolClassId')) {
            $data['school_class_id'] =
                $this->input('schoolClassId');
        }

        if ($this->has('fullName')) {
            $data['full_name'] =
                $this->input('fullName');
        }

        if ($this->has('birthDate')) {
            $data['birth_date'] =
                $this->input('birthDate');
        }

        if ($this->has('averageScore')) {
            $data['average_score'] =
                $this->input('averageScore');
        }

        if ($this->has('hasBenefit')) {
            $data['has_benefit'] =
                $this->input('hasBenefit');
        }

        $this->merge($data);
    }

    public function rules(): array
    {
        $pupilId = $this->route('pupil')?->id;

        $required =
            $this->isMethod('PATCH')
                ? 'sometimes'
                : 'required';

        return [
            'school_class_id' => [
                $required,
                'integer',
                'exists:school_classes,id',
            ],

            'full_name' => [
                $required,
                'string',
                'min:4',
                'max:115',
            ],

            'birth_date' => [
                $required,
                'date',
                'before_or_equal:today',
            ],

            'email' => [
                $required,
                'email',
                'max:100',
                Rule::unique(
                    'pupils',
                    'email'
                )->ignore($pupilId),
            ],

            'average_score' => [
                $required,
                'numeric',
                'between:0,5',
            ],

            'has_benefit' => [
                $required,
                'boolean',
            ],
        ];
    }
}