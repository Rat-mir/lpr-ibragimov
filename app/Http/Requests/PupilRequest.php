<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PupilRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $pupilId = $this->route('pupil')?->id;

        return [
            'school_class_id' => [
                'required',
                'integer',
                'exists:school_classes,id',
            ],

            'full_name' => [
                'required',
                'string',
                'min:4',
                'max:115',
            ],

            'birth_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],

            'email' => [
                'required',
                'email',
                'max:100',

                Rule::unique(
                    'pupils',
                    'email'
                )->ignore($pupilId),
            ],

            'average_score' => [
                'required',
                'numeric',
                'between:0,5',
            ],

            'has_benefit' => [
                'boolean',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'required' =>
                'Поле «:attribute» обязательно.',

            'full_name.min' =>
                'ФИО должно содержать не менее :min символов.',

            'full_name.max' =>
                'ФИО должно содержать не более :max символов.',

            'email.email' =>
                'Введите корректный email.',

            'email.unique' =>
                'Ученик с таким email уже существует.',

            'school_class_id.exists' =>
                'Выбранный класс не существует.',

            'birth_date.before_or_equal' =>
                'Дата рождения не может быть в будущем.',

            'average_score.between' =>
                'Средний балл должен быть от :min до :max.',
        ];
    }

    public function attributes(): array
    {
        return [
            'school_class_id' => 'Класс',
            'full_name' => 'ФИО',
            'birth_date' => 'Дата рождения',
            'email' => 'Email',
            'average_score' => 'Средний балл',
            'has_benefit' => 'Льгота',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'has_benefit' =>
                $this->boolean('has_benefit'),
        ]);
    }
}