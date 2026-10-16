<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PupilResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'fullName' => $this->full_name,

            'birthDate' => $this->birth_date?->format('Y-m-d'),

            'email' => $this->email,

            'averageScore' => (float) $this->average_score,

            'hasBenefit' => (bool) $this->has_benefit,

            'schoolClass' => [
                'id' => $this->school_class_id,

                'name' => $this->whenLoaded(
                    'schoolClass',
                    fn () => $this->schoolClass->name
                ),

                'year' => $this->whenLoaded(
                    'schoolClass',
                    fn () => $this->schoolClass->year
                ),
            ],

            'createdAt' =>
                $this->created_at?->toIso8601String(),
        ];
    }
}