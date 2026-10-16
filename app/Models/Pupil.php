<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pupil extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_class_id',
        'full_name',
        'birth_date',
        'email',
        'average_score',
        'has_benefit',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'average_score' => 'decimal:2',
            'has_benefit' => 'boolean',
        ];
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function clubs(): BelongsToMany
{
    return $this->belongsToMany(
        Club::class
    );
}
}